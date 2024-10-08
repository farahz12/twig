<?php
// src/Controller/StudentController.php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student/lists', name: 'list_students')]
    public function listStudents(EntityManagerInterface $entityManager): Response
    {
        $students = $entityManager->getRepository(Student::class)->findAll();

        return $this->render('student/lists.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/student/add', name: 'add_student')]
    public function addStudent(Request $request, EntityManagerInterface $entityManager): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('list_students');
        }

        return $this->render('student/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
