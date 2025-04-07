<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\CongeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class StatsController extends AbstractController
{
    private $congeRepository;
    private $userRepository;

    public function __construct(CongeRepository $congeRepository, UserRepository $userRepository)
    {
        $this->congeRepository = $congeRepository;
        $this->userRepository = $userRepository;
    }

    #[Route('/stats', name: 'app_stats')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer le nombre total de congés
        $totalConges = $this->congeRepository->count([]);
        $congesParType = $this->congeRepository->createQueryBuilder('c')
            ->select('c.type, COUNT(c.id) as count')
            ->groupBy('c.type')
            ->getQuery()
            ->getResult();

        // Requête SQL pour récupérer le nombre total de congés par type
        $connection = $entityManager->getConnection();
        $sql = 'SELECT c.type, COUNT(c.id) as count 
                FROM conge c 
                GROUP BY c.type';
        $stmt = $connection->prepare($sql);
        $congesParTypeSQL = $stmt->executeQuery()->fetchAllAssociative();

        return $this->render('stats/index.html.twig', [
            'totalConges' => $totalConges,
            'congesParType' => $congesParType,
            'congesParTypeSQL' => $congesParTypeSQL,
        ]);
    }

    #[Route('/stats/user', name: 'app_stats_user')]
    public function statsParUtilisateur(EntityManagerInterface $entityManager): Response
    {
        // Requête DQL pour compter les congés par utilisateur
        $startTimeDQL = microtime(true);
        $congesParUser = $this->congeRepository->createQueryBuilder('c')
            ->select('u.nom, u.prenom, COUNT(c.id) as count')
            ->join('c.user', 'u')
            ->groupBy('u.id')
            ->getQuery()
            ->getResult();
        $endTimeDQL = microtime(true);
        $executionTimeDQL = round(($endTimeDQL - $startTimeDQL) * 1000, 2); // Temps en ms

        // Requête SQL directe pour compter les congés par utilisateur
        $startTimeSQL = microtime(true);
        $connection = $entityManager->getConnection();
        $sql = 'SELECT u.nom, u.prenom, COUNT(c.id) as count 
                FROM conge c 
                JOIN user u ON c.user_id = u.id 
                GROUP BY u.nom, u.prenom';
        $stmt = $connection->prepare($sql);
        $congesParUserSQL = $stmt->executeQuery()->fetchAllAssociative();
        $endTimeSQL = microtime(true);
        $executionTimeSQL = round(($endTimeSQL - $startTimeSQL) * 1000, 2); // Temps en ms

        return $this->render('stats/user_stats.html.twig', [
            'congesParUser' => $congesParUser,
            'executionTimeDQL' => $executionTimeDQL . " ms",
            'congesParUserSQL' => $congesParUserSQL,
            'executionTimeSQL' => $executionTimeSQL . " ms",
        ]);
    }

    #[Route('/stats/alerts', name: 'app_stats_alerts')]
    public function alerts(): Response
    {
        // Pour la démo, on récupère tous les utilisateurs et on leur attribue une date d'expiration aléatoire
        $employees = $this->userRepository->findAll();
        $alerts = [];
        foreach ($employees as $employee) {
            // Génère un offset aléatoire entre 0 et 60 jours à partir d'aujourd'hui
            $offset = rand(0, 60);
            $expiration = (new \DateTime())->modify("+{$offset} days");

            $alerts[] = [
                'employee'   => $employee,
                'expiration' => $expiration,
            ];
        }
        return $this->render('stats/alerts.html.twig', [
            'alerts' => $alerts,
        ]);
    }

    #[Route('/stats/rh-dashboard', name: 'app_stats_rh_dashboard')]
    public function rhDashboard(): Response
    {
        // Données simulées pour le dashboard RH
        $dashboardData = [
            [
                'departement'    => 'IT',
                'typeConge'      => 'CP',
                'totalCarryOver' => 12,
                'ajustement'     => -2,
                'totalFinal'     => 10,
            ],
            [
                'departement'    => 'RH',
                'typeConge'      => 'RTT',
                'totalCarryOver' => 8,
                'ajustement'     => 1,
                'totalFinal'     => 9,
            ],
            [
                'departement'    => 'Finance',
                'typeConge'      => 'CP',
                'totalCarryOver' => 15,
                'ajustement'     => 0,
                'totalFinal'     => 15,
            ],
        ];

        return $this->render('stats/rh_dashboard.html.twig', [
            'dashboardData' => $dashboardData,
        ]);
    }
}
