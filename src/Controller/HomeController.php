<?php

namespace App\Controller;

use App\Entity\Configuration;
use App\Entity\Transaction;
use App\Entity\Username;
use App\Form\TransactionType;
use App\Form\UsernameType;
use App\Repository\ConfigurationRepository;
use App\Repository\TransactionRepository;
use App\Repository\UsernameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // FRONT REACT

    /**
     * @Route("/{reactRouting}", name="home", defaults={"reactRouting": null})
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', []);
    }

    // API

    protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }

    /**
     * @Route("/api/users")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function postUser(Request $request, EntityManagerInterface $em, UsernameRepository $usernameRepository)
    {
        $request = $this->transformJsonBody($request);

        $user = new Username();

        $user->setName($request->get('username')['user']);
        $user->setColor($request->get('username')['color']);

        $em->persist($user);
        $em->flush();
        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $response->setContent(json_encode($user));

        return $response;
    }

    /**
     * @Route("/homes", name="accueil")
     */
    public function home(TransactionRepository $transaction, EntityManagerInterface $em): Response
    {
        $configuration = $this->getDoctrine()
            ->getRepository(Configuration::class)
            ->findLaunch();

        $configuration = $configuration[0]["statut"];

        if($configuration == 0) {
            return $this->redirectToRoute('whoareyou');
        }
        else {

            $this->transaction = $transaction;

            $transactions = $this->getDoctrine()
                ->getRepository(Transaction::class)
                ->findCommun();

            $qb = $em->getConnection()->prepare("SELECT date_transaction FROM transaction WHERE statut = 0 AND type != 3 ORDER BY date_transaction ASC LIMIT 1");
            $qb->execute();
            $dateDebut = $qb->fetchAll();

            if ($dateDebut) {
                $dateDebut = $dateDebut[0]["date_transaction"];
            } else {
                $dateDebut = 0;
            }

            $qb = $em->getConnection()->prepare("SELECT date_transaction FROM transaction WHERE statut = 0 AND type != 3 ORDER BY date_transaction DESC LIMIT 1");
            $qb->execute();
            $dateFin = $qb->fetchAll();


            if ($dateFin) {
                $dateFin = $dateFin[0]["date_transaction"];
            } else {
                $dateFin = 0;
            }

            return $this->render('home.html.twig', [
                'selected' => "dashboard",
                'transactions' => $transactions,
                'dateDebut' => $dateDebut,
                'dateFin' => $dateFin
            ]);
        }
    }

    /**
     * @Route("/mathis", name="mathis")
     */
    public function mathis(TransactionRepository $transaction): Response
    {
        $this->transaction = $transaction;

        $transactions = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findPerso('Mathis');

        $monthLastStart = date("Y-m-j", strtotime("first day of previous month"));
        $monthLastEnd = date("Y-m-j", strtotime("last day of previous month"));
        $amountLast = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findDepensesMonth("Mathis", $monthLastStart, $monthLastEnd);

        $totalLast = 0;
        foreach ($amountLast as $total) {
            $totalLast = $totalLast + $total['amount'];
        }

        if($amountLast == NULL)
            $amountLast = 0;

        $monthNowStart = date('Y-m-01');
        $monthNowEnd = date('Y-m-d');
        $amountNow = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findDepensesMonth("Mathis", $monthNowStart, $monthNowEnd);

        $totalNow = 0;
        foreach ($amountNow as $total) {
            $totalNow = $totalNow + $total['amount'];
        }

        if($amountNow == NULL)
            $amountNow = 0;

        return $this->render('perso.html.twig', [
            'selected' => "mathis",
            'transactions' => $transactions,
            'amountNow' => $amountNow,
            'amountLast' => $amountLast,
            'totalNow' => $totalNow,
            'totalLast' => $totalLast,
        ]);
    }

    /**
     * @Route("/abigail", name="abigail")
     */
    public function abigail(TransactionRepository $transaction): Response
    {
        $this->transaction = $transaction;

        $transactions = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findBy([
                'username' => 'Abigail'
            ], [
                'dateTransaction' => 'DESC'
            ]);

        $monthLastStart = date("Y-m-j", strtotime("first day of previous month"));
        $monthLastEnd = date("Y-m-j", strtotime("last day of previous month"));
        $monthLast = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findDepensesMonth("Abigail", $monthLastStart, $monthLastEnd);

        $amountLast = $monthLast[0]['amount'];
        if($amountLast == NULL)
            $amountLast = 0;

        $monthNowStart = date('Y-m-01');
        $monthNowEnd = date('Y-m-d');
        $monthNow = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findDepensesMonth("Abigail", $monthNowStart, $monthNowEnd);

        $amountNow = $monthNow[0]['amount'];
        if($amountNow == NULL)
            $amountNow = 0;

        return $this->render('perso.html.twig', [
            'selected' => "abigail",
            'transactions' => $transactions,
            'amountNow' => $amountNow,
            'amountLast' => $amountLast,
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, ManagerRegistry $managerRegistry, TransactionRepository $tr): Response
    {
        $this->tr = $tr;

        $tr = new Transaction();

        $form = $this->createForm(TransactionType::class, $tr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            $em->persist($tr);
            $em->flush();
            $this->addFlash('success', 'Résidence créée avec succès');

            return $this->redirectToRoute('home');
        }

            return $this->render('add.html.twig', [
            'tr' => $tr,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/updateAll", name="updateAll")
     */
    public function updateAll(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $transaction = $entityManager->getRepository(Transaction::class)->findBy(['statut' => 0]);

        foreach ($transaction as $tr) {
            $tr->setStatut(1);
        }

        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $transaction = $entityManager->getRepository(Transaction::class)->find($id);

        $transaction->setStatut(1);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $transaction = $entityManager->getRepository(Transaction::class)->find($id);

        $entityManager->remove($transaction);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }
}
