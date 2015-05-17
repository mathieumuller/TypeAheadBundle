<?php
namespace MatM\Bundle\TypeAheadBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class TypeAheadTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;
    private $objectClass;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, $objectClass)
    {
        $this->om = $om;
        $this->objectClass = $objectClass;
    }

    /**
     * Transforms an object (type) to an int (id).
     *
     * @param  Type|null $type
     * @return int
     */
    public function transform($type)
    {
        if (null === $type) {
            return "";
        }

        return $type;
    }

    /**
     * Transforms an int (id) to an object (type).
     *
     * @param  int $id
     * @return Type|null
     * @throws TransformationFailedException if object (type) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $type = $this->om
            ->getRepository($this->objectClass)
            ->find($id)
        ;

        if (null === $type) {
            throw new TransformationFailedException(sprintf(
                "An error occured",
                $id
            ));
        }

        return $type;
    }
}
