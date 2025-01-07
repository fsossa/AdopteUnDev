<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Developer;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class RegistrationController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {

    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->add('firstname', TextType::class, [
            'label' => 'Prénom(s)',
            'mapped' =>false,
            'attr' => [
                'class' => 'form-control',
                'required' => true,
            ],
        ]);
        $form->add('lastname', TextType::class, [
            'label' => 'Nom',
            'mapped' =>false,
            'attr' => [
                'class' => 'form-control',
                'required' => true,
            ],
        ]);
        $form->handleRequest($request);

        $company = new User();
        $formCompany = $this->createForm(RegistrationFormType::class, $company);
        $formCompany->add('name', TextType::class, [
            'label' => 'Nom de l\'entreprise',
            'mapped' =>false,
            'attr' => [
                'class' => 'form-control',
                'required' => true,
            ],
        ]);
        $formCompany->add('location', TextType::class, [
            'label' => 'Adresse',
            'mapped' =>false,
            'attr' => [
                'class' => 'form-control',
                'required' => false,
            ],
        ]);
        $formCompany->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            $user->setRoles(["ROLE_USER", "ROLE_DEV"]);
            $entityManager->persist($user);

            // Create developer for this user
            $developer = new Developer();
            $developer->setUser($user);
            $developer->setFirstname($form->get("firstname")->getData());
            $developer->setLastname($form->get("lastname")->getData());

            $entityManager->persist($developer);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    // ->from(new Address((string) getenv('MAIL_FROM_ADRESS', true) ?? 'noreply@adopteundev.com', 'Noreply'))
                    ->from(new Address('fulbsossa16@gmail.com', 'Noreply'))
                    ->to((string) $user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email

            return $security->login($user, LoginFormAuthenticator::class, 'main');
        }
        else if ($formCompany->isSubmitted() && $formCompany->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $formCompany->get('plainPassword')->getData();

            // encode the plain password
            $company->setPassword($userPasswordHasher->hashPassword($company, $plainPassword));
            $company->setRoles(["ROLE_USER", "ROLE_COMPANY"]);

            $entityManager->persist($company);

            // Create company for this user
            $_company = new Company();
            $_company->setUser($company);
            $_company->setName($formCompany->get("name")->getData());
            $_company->setLocation($formCompany->get("location")->getData());

            $entityManager->persist($_company);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $company,
                (new TemplatedEmail())
                    ->from(new Address(getenv('MAIL_FROM_ADRESS', true) ?? 'noreply@adopteundev.com', 'Noreply'))
                    ->to((string) $company->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email

            return $security->login($company, LoginFormAuthenticator::class, 'main');
        }else{
            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form,
                'registrationFormCompany' => $formCompany,
            ]);
        }

        
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UserRepository $userRepository): Response
    {
        $id = $request->query->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('home');
    }
}
