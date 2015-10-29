<?php

namespace CeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class EmailCollectorFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array(
                'label' => false,
                'attr'  => array(
                    'placeholder' => 'contact.form.email_placeholder',
                ),
                'constraints' => array(
                    new NotBlank(array('message' => 'contact.email.blank')),
                    new Email(array('message' => 'contact.email.email')),
                ),
            ))
            ->add('save', 'submit', array(
                'label' => 'OK',
                'attr'  => array(
                    'class' => 'save',
                ),
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ce_email_collector';
    }
}
