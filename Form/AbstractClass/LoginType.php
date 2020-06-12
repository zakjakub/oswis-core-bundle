<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisCoreBundle\Form\AbstractClass;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'username',
            TextType::class,
            [
                'label'    => 'Uživatelské jméno',
                'help'     => 'Zadejte uživatelské jméno nebo e-mail uvedený u uživatelského účtu.',
                'mapped'   => false,
                'required' => true,
            ]
        );
        $builder->add(
            'password',
            PasswordType::class,
            [
                'label'    => 'Heslo',
                'help'     => 'Zadejte Vaše heslo. Je nutné dodržet velká a malá písmena.',
                'mapped'   => false,
                'required' => true,
            ]
        );
        $builder->add(
            'submit',
            SubmitType::class,
            ['label' => 'PŘIHLÁSIT SE']
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }

    public function getBlockPrefix(): string
    {
        return 'core_app_user_login';
    }
}
