<?php

namespace App\Form;

use App\Entity\Responses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('worker_date')
            ->add('worker_status')
            ->add('employer_date')
            ->add('employer_status')
            ->add('resume_id')
            ->add('vacancy_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Responses::class,
        ]);
    }
}
