<?php

namespace App\Form;

use App\Entity\Vacancy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VacancyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'актуальна' => 'актуальна',
                    'не актуальна' => 'не актуальна'
                ]
            ])
            ->add('work_place')
            ->add('work_experience')
            ->add('education')
            ->add('job_description')
            ->add('learning_opportunity')
            ->add('info')
            ->add('organization_id')
            ->add('payment_form')
            ->add('employment_type')
            ->add('salary')
            ->add('position_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vacancy::class,
        ]);
    }
}
