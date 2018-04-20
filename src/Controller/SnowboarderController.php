<?php

namespace App\Controller;

require_once '/Users/alexei/Sites/SnowTricks/vendor/autoload.php';

use Symfony\Component\Finder\Finder;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Symfony\Component\Form\RequestHandlerInterface;


use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


use App\Entity\Message;
use App\Entity\Snowboarder;


class SnowboarderController extends Controller
{
    
	/**
 	* @Route("/createaccount", name="createaccount")
 	*/
	public function createaccountAction(Request $request)
	{
		$Snowboarder = new Snowboarder();

    	$formSnowboarder = $this->createFormBuilder($Snowboarder)
        ->add('name',     TextType::class)
        ->add('email',     TextType::class)
        ->add('password',     TextType::class)
		->add('save',      SubmitType::class)
        ->getForm();

		$formSnowboarder->handleRequest($request);

		if ($formSnowboarder->isSubmitted() && $formSnowboarder->isValid()) {
        	$Snowboarder = $formSnowboarder->getData();
        	//$formSnowboarder->getToken();
        	
        	//$formSnowboarder->sendmail()
        	
        	$em = $this->getDoctrine()->getManager();
        	$em->persist($Snowboarder);
        	$em->flush();
        	
        	$this->addFlash('messages', 'Vous venez de créer un compte!!' );

        	return $this->redirectToRoute('index');
    	}
    	

    return $this->render('accueil/createaccount.html.twig', array(
        'formSnowboarder' => $formSnowboarder->createView(),
    ));
		
	}
	
	
	/**
 	* @Route("/connect", name="connect")
 	*/
	public function connectAction(Request $request)
	{
		$Snowboarder = new Snowboarder();

    	$formSnowboarder = $this->createFormBuilder($Snowboarder)
        ->add('name',     TextType::class)
        ->add('password',     PasswordType::class)
		->add('Se connecter',      SubmitType::class)
        ->getForm();

		$formSnowboarder->handleRequest($request);

		if ($formSnowboarder->isSubmitted() ) {
        	$Snowboarder = $formSnowboarder->getData();
        	 
        	$name = $Snowboarder->getName();
        	$pwd = $Snowboarder->getPassword();
        	
        	$SnowboarderDB = $this->getDoctrine()
    		->getRepository(Snowboarder::class)
    		->findOneWithNameAndEmail($name, $pwd);
    		
    		
    		
    		if(isset($SnowboarderDB[0])){
				$session = new Session();
				$session->start();
				$session->set('name', $SnowboarderDB[0]->getName());
				$session->getFlashBag()->add('notice', 'Profile updated');
				echo 'test : ' . $session->getId();
				$session->set('sessionId', $session->getId());
				$this->addFlash('messages', 'Bienvenue parmi nous ' . $SnowboarderDB[0]->getName() . '!' );
				
				return $this->redirectToRoute('index');
			}else{
				return $this->render('accueil/connected.html.twig', array('unknown' => true)); 
			}
        	
    	}
    	

    return $this->render('accueil/connect.html.twig', array(
        'formSnowboarder' => $formSnowboarder->createView(),
    ));
		
	}
	
	
	
	/**
 	* @Route("/disconnect/{sessionId}", name="disconnect")
 	*/
	public function disconnectAction(Request $request, $sessionId)
	{	
		$session = new Session();
		$name = $session->get('name');
		$session->clear($sessionId);
		
		$this->addFlash('messages', 'Au revoir et à bientôt ' . $name );
		return $this->redirectToRoute('index');
		
	}
	
    
    
     
   


	
   
}



















