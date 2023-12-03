<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $currentUser = $this->security->getUser();

        $builder
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->add('author', ChoiceType::class, [
                'choices' => [$currentUser->getUsername() => $currentUser],
                'mapped' => false, // This is important if 'author' is not a property of your entity
            ])
        ;
    }
}
