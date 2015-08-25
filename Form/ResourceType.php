<?php

namespace FormaLibre\ReservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @DI\Service("formalibre.form.resource")
 */
class ResourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
                'label' => 'form.name'
            )
        );

        $builder->add('description', 'textarea', array(
            'label' => 'form.description'
        ));

        $builder->add('localisation', 'text', array(
            'label' => 'form.localisation'
        ));

        $builder->add('maxTimeReservation', 'time', array(
            'input' => 'string',
            'widget' => 'single_text',
            'label' => 'form.maxTime'
        ));

        $builder->add('quantity', 'integer', array(
            'label' => 'form.quantity',
            'empty_data' => 1
        ));
    }

    public function getName()
    {
        return 'resource_form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'class' => 'FormaLibre\ReservationBundle\Entity\Resource',
                'translation_domain' => 'reservation'
            )
        );
    }
}