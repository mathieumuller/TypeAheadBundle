<?php
namespace MatM\Bundle\TypeAheadBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MatM\Bundle\TypeAheadBundle\Form\DataTransformer\TypeAheadTransformer;

class TypeAheadType extends AbstractType
{
    /**
     * @var TypeAheadTransformer
     */
    private $transformer;

    /**
     * @param TypeAheadTransformer $transformer
     */
    public function __construct(TypeAheadTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->transformer->setClass($options['data_class']);
        $builder->addModelTransformer($this->transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => "An error occured",
        ));
    }

    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'typeahead';
    }
}
