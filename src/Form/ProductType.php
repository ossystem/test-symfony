<?php
namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
              ->add('name', TextType::class, [
                  'constraints' => new NotBlank([
                      'groups' => [ 'Default', 'type1', 'type2' ],
                      'message' => "Name is required",
                  ]),
              ])
              ->add('type', ChoiceType::class, [
                  'choices' => [ 1, 2 ],
                  'constraints' => new NotBlank([
                      'groups' => [ 'Default', 'type1', 'type2' ],
                      'message' => "Type is required and must be 1 or 2",
                  ]),
              ])
              ->add('color', TextType::class, [
                  'constraints' => new NotBlank([
                      'groups' => 'type1',
                      'message' => 'Color is required',
                  ]),
              ])
              ->add('texture', TextType::class, [
                  'constraints' => new NotBlank([
                      'groups' => 'type1',
                      'message' => 'Texture is required',
                  ]),
              ])
              ->add('height', IntegerType::class, [
                  'invalid_message' => 'Height should be integer',
                  'constraints' => new NotBlank([
                      'groups' => 'type2',
                      'message' => 'Height is required',
                  ]),
              ])
              ->add('width', IntegerType::class, [
                  'invalid_message' => 'Width should be integer',
                  'constraints' => new NotBlank([
                      'groups' => 'type2',
                      'message' => 'Width is required',
                  ]),
              ])
              ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                  $data = $event->getData();
                  $form = $event->getForm();

                  if (!$data || $data && !isset($data['type'])) {
                      return;
                  }

                  switch ($data['type']) {
                      case Product::TYPE_1:
                        unset($data['height']);
                        unset($data['width']);
                        break;
                      case Product::TYPE_2:
                        unset($data['color']);
                        unset($data['texture']);
                        break;
                  }

                  $event->setData($data);
              })
          ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => function (FormInterface $form) {
                $data = $form->getData();

                switch ($data->getType()) {
                    case Product::TYPE_1: return ['type1'];
                    case Product::TYPE_2: return ['type2'];
                }

                return ['Default'];
            },
        ]);
    }

    public function getName()
    {
        return 'product';
    }
}
