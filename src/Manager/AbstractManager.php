<?php

namespace App\Manager;

//use SSH\CommonBundle\Utils\MyTools;
//use SSH\CommonBundle\Manager\ExceptionManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use App\Entity\Polygon;

/* * `
 * Base class for most animation objects.
 */

abstract class AbstractManager //implements ModelInterface
{
    /**
     * Date format
     */
//    const DATE_FORMAT = 'Y-m-d';

    /**
     * Date format FR
     */
    const SQL_DATE_FORMAT_FR = 'DD-MM-YYYY';

    /**
     * Date format EN
     */
    const SQL_DATE_FORMAT_EN = 'YYYY-MM-DD';

    /**
     * ROLES FRONT
     */
    const ROLE_SUPER_USER = 'ROLE_SUPER_USER';
    const ROLE_USER = 'ROLE_USER';

    /**
     * ROLES FITTER
     */
    const ROLE_SUPER_FITTER = 'ROLE_SUPER_FITTER';
    const ROLE_FITTER = 'ROLE_FITTER';

    /**
     * settings.
     *
     * @var array
     */
    protected $settings;

    /**
     * @var ExceptionManager
     */
    protected $exceptionManager;

    /**
     * @var entityManager
     */
    protected $apiEntityManager;

    /**
     *  @var BackUser
     */
    protected $userCaller;

    /**
     *
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $userData = [];

    /**
     * @var object
     */
    protected $object;

    /**
     * AbstractModel constructor.
     *
     * @param Registry $entityManager
     * @param ExceptionManager $exceptionManager
     * @param RequestStack $requestStack
     */
    public function __construct(Registry $entityManager/*, ExceptionManager $exceptionManager*/, RequestStack $requestStack = null)
    {
        $this->apiEntityManager = $entityManager->getManager();
        //$this->exceptionManager = $exceptionManager;

        if ($requestStack instanceof RequestStack) {
            $this->request = $requestStack->getCurrentRequest();
        }
    }

    protected function getSqlDateFormat()
    {
        if ($this->request->getLocale() == 'en') {
            return self::SQL_DATE_FORMAT_EN;
        }
        return self::SQL_DATE_FORMAT_FR;
    }

    protected function setSettings($settings)
    {
        $this->settings = $settings;

        $accessor = PropertyAccess::createPropertyAccessor();
        foreach ($this->settings as $property => $value) {
            try {
                $accessor->setValue($this, $property, $value);
            } catch (ExceptionInterface $e) {
                throw $e;
            }
        }
        return $this;
    }

    protected function validateUnicity($class, $field, $options)
    {
        $object = $this->apiEntityManager
                ->getRepository($class)
                ->findOneBy($options);

//        if ($object instanceof $class) {
//            $this->exceptionManager->throwFoundException([$field]);
//        }
    }

    public function import($class, $field = null, $options = array())
    {
        $importData = $this->request->get('data');

//        if (empty($importData)) {
//            $this->exceptionManager->throwPreconditionFailedException('empty_data');
//        }

        $errors = $identifiers = [];

        foreach ($importData as $index => $modelData) {

            try {

                if (!empty($options)) {
                    foreach ($options as $optionKey => $option) {
                        $options[$optionKey] = $modelData[$option];
                    }
                }

                $identifiers[$index] = $this->insertObject($modelData, $class, $field, $options)->getCode();
            } catch (\Exception $ex) {
                $errors[$index] = $ex->getMessage();
            }
        }

        $data = ['messages' => 'import_success', 'values' => $identifiers];

        if (!empty($errors)) {

            $data = [
                'messages' => 'import_success_partially',
                'errors' => $errors,
            ];
        }

        return ['data' => $data];
    }

    public function insertObject($data, $class, $field = null, $options = array())
    {
        if ($field && count($options)) {
            $this->validateUnicity($class, $field, $options);
        }

        $object = new $class($data);

        $this->apiEntityManager->persist($object);
        $this->apiEntityManager->flush();

        return $object;
    }

    /**
     * @return array
     */
    protected function deleteObject($object)
    {
        if ($object instanceof \SSH\CommonBundle\Entity\AbstractEntity) {

            $this->apiEntityManager->remove($object);
            $this->apiEntityManager->flush();

            return ['data' => [
                    'messages' => 'delete_success',
            ]];
        }

        return ['data' => [
                'messages' => 'delete_fail',
        ]];
    }

    /**
     * @return array
     */
    protected function setObjectState($object)
    {
        if (method_exists($object, 'setActive')) {
            $object->setActive(!$object->getActive());
        }

        if (method_exists($object, 'setUpdatedAt')) {
            $object->setUpdatedAt(new \DateTime());
        }

        $this->apiEntityManager->persist($object);
        $this->apiEntityManager->flush();

        return ['data' => [
                'messages' => 'update_success',
                'object' => $object->getCode(),
        ]];
    }

    protected function updatePolygon($data)
    {
        $polygon = $this->apiEntityManager
                ->getRepository(Polygon::class)
                ->findOneBy(['code' => $data['code']]);

//        if (empty($polygon)) {
//            $this->exceptionManager->throwNotFoundException('UNKNOWN_POLYGON');
//        }

        if (!is_array($data['coordinates'])) {
            $data['coordinates'] = json_decode($data['coordinates'], true);
        }

        $polygon->fromArray($data)
                ->setUpdatedAt(new \DateTime());

        $this->apiEntityManager->persist($polygon);
        $this->apiEntityManager->flush();

        return $polygon;
    }

    protected function insertOrUpdatePolygon(&$data, $prefix, $insert = true)
    {
        $tmp = [];
        foreach ($data as $index => $value) {
            if (preg_match('/^' . $prefix . '[a-z_]+$/', $index)) {
                unset($data[$index]);
                $index = str_replace($prefix . '_', '', $index);

                if ($index == 'coordinates') {
                    $value = json_decode($value, true);
                }
                $tmp[$index] = $value;
            }
        }

        $data[$prefix] = $tmp;
        if (!empty($tmp)) {
            if ($insert) {
                $tmp['code'] = "cjhfguyjtfuytftyf";//MyTools::GUIDv4();
                $data[$prefix] = $this->insertObject($tmp, Polygon::class, 'label', ['label' => $tmp['label']]);
            } else {
                $data[$prefix] = $this->updatePolygon($tmp);
            }
        }
    }

}
