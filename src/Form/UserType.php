<?php
/**
 * Created by PhpStorm.
 * User: Mekki
 * Date: 13/04/2020
 * Time: 21:44
 */

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('first_name', TextType::class)
            ->add('last_name', TextType::class)
            ->add('birth_date', BirthdayType::class, [
                //'format' => 'dd-MM-yyyy',
                'years' => range(1920, date('Y')),
            ])
            //https://www.facebook.com/profile.php
            ->add('facebook_link', TextType::class, [
                //'help' => 'Click on the button above to get your facebook profile automatically !',
            ])
            ->add('photo', FileType::class,
                array(
                    'attr' => array(
                        'accept' => "image/jpeg, image/png"
                    ),
                    'constraints' => [
                        new File([
                            'maxSize' => '2M',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                            ],
                            'mimeTypesMessage' => 'Please upload a JPG or PNG',
                        ])
                    ]
                ))
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class)
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

}