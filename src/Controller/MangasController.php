<?php

namespace App\Controller;

use App\Entity\Characters;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Mangas;
use App\Form\MangasType;
use App\Manager\MangasManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MangasController extends AbstractController
{
    #[Route("/", name: "home")]
    public function Home()
    {
        return $this -> render("Mangas/Home.html.twig");
    }

    #[Route("/manga/{id}", name: "manga")]
    public function getManga($id, EntityManagerInterface $doctrine)
    {
        $repo = $doctrine -> getRepository(Mangas ::class);
        $manga = $repo ->find($id);
        return $this -> render("Mangas/Manga.html.twig", ["manga" => $manga]);
        
    }

    #[Route("/mangaslist", name: "mangasList")]
    public function getMangasList(EntityManagerInterface $doctrine)
    {
        $repo = $doctrine -> getRepository(Mangas ::class);
        $mangasList = $repo -> findAll();
        return $this -> render("Mangas/MangaList.html.twig", ["mangasList" => $mangasList]);
        
    }

    /*
    #[Route("/addmanga", name: "addmanga")]
    public function addMangas(EntityManagerInterface $doctrine)
    {
        $manga = new Mangas();
        $manga -> setName("The Promised Neverland");
        $manga -> setImage("https://static.serlogal.com/imagenes_big/9788467/978846793676.JPG");
        $manga -> setYear("2016");

        $manga2 = new Mangas();
        $manga2 -> setName("Slam Dunk");
        $manga2 -> setImage("https://tienda.tomosygrapas.com/24634-large_default/slam-dunk-kanzenabn-01.jpg");
        $manga2 -> setYear("1990");

        $character = new Characters();
        $character -> setName("Ray");
        $character -> setImage("https://i.pinimg.com/originals/34/07/69/3407699a2b9d5c7e980cebf5e18eaf0a.png");
        $character -> setRole("Protagonista");
        $manga -> addCharacter($character);

        $character2 = new Characters();
        $character2 -> setName("Hanamichi Sakuragi");
        $character2 -> setImage("https://i.pinimg.com/564x/0b/6c/f7/0b6cf7a8e1fcd8788f96eb9db8d92530.jpg");
        $character2 -> setRole("Protagonista");
        $manga2 -> addCharacter($character2);

        $doctrine -> persist($manga);
        $doctrine -> persist($character);
        $doctrine -> persist($manga2);
        $doctrine -> persist($character2);


        $doctrine ->flush();
        return new Response("Manga insertado");
        
    }
    */

    #[Route("/character/{id}", name: "character")]
    public function getCharacter($id, EntityManagerInterface $doctrine)
    {
        $repo = $doctrine -> getRepository(Characters ::class);
        $character = $repo ->find($id);
        return $this -> render("Mangas/Character.html.twig", ["character" => $character]);
        
    }

    #[Route("/characterslist", name: "characterslist")]
    public function getCharactersList(EntityManagerInterface $doctrine)
    {
        $repo = $doctrine -> getRepository(Characters ::class);
        $charactersList = $repo -> findAll();
        return $this -> render("Mangas/CharacterList.html.twig", ["charactersList" => $charactersList]);
        
        
    }

    #[Route("/createManga", name: "createManga")]
    public function createManga(EntityManagerInterface $doctrine, Request $request, MangasManager $manager)
    {
        $form = $this -> createForm(MangasType::class);
        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form -> isValid()){
            $manga = $form -> getData();
            //Recogemos el fichero imagen del formulario
            $imageFile = $form -> get("imageFile") -> getData();
            if($imageFile) {
                $image = $manager -> uploadImage($imageFile, $this->getParameter('kernel.project_dir').'/public/images' );
                $manga -> setImage("/images/$image");
            }
            $doctrine -> persist($manga);
            $doctrine -> flush();
            $this -> addFlash("Éxito", "Manga insertado correctamente");
            return $this -> redirectToRoute("mangasList");
        }
        return $this -> renderForm("Mangas/CreateManga.html.twig", ["MangaForm" => $form]);
    }

    #[Route("/editManga/{id}", name: "editManga")]
    public function editManga(EntityManagerInterface $doctrine, Request $request, $id)
    {
        $repo = $doctrine -> getRepository(Mangas::class);
        $manga = $repo -> find($id);
        $form = $this -> createForm(MangasType::class, $manga);
        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form -> isValid()){
            $manga = $form -> getData();
            $doctrine -> persist($manga);
            $doctrine -> flush();
            $this -> addFlash("Éxito", "Manga editado correctamente");
            return $this -> redirectToRoute("mangasList");
        }
        return $this -> renderForm("Mangas/CreateManga.html.twig", ["MangaForm" => $form]);
    }

    #[Route("/removeManga/{id}", name: "removeManga")]
    #[IsGranted("ROLE_ADMIN")]
    public function removeManga(EntityManagerInterface $doctrine, $id)
    {
        $repo = $doctrine -> getRepository(MangasType::class);
        $manga = $repo -> find($id);
        $doctrine -> remove(($manga));
        $doctrine -> flush();
        $this -> addFlash("Éxito", "Manga editado correctamente");
        return $this -> redirectToRoute("mangasList");
    }
}