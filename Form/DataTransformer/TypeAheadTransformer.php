<?php
namespace MatM\Bundle\TypeAheadBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class TypeAheadTransformer implements DataTransformerInterface
{
    private $class;

    /**
     * Gets the value of class.
     *
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Sets the value of class.
     *
     * @param mixed $class the class
     *
     * @return self
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @var ObjectManager
     */
    private $om;
    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (entity) to an int (id).
     *
     * @param  Entity|null $entity
     * @return int
     */
    public function transform($entity)
    {
        return null === $entity ? "" : $entity;
    }

    /**
     * Transforms an int (id) to an object (entity).
     *
     * @param  int $id
     * @return Entity|null
     * @throws TransformationFailedException if object (entity) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $entity = $this->om
            ->getRepository($this->class)
            ->find($id);

        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                "No result found for id %d",
                $id
            ));
        }

        return $entity;
    }
}
