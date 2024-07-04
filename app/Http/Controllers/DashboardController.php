<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
{
    // Profits (Jour) - Montant total aujourd'hui
    $profitToday = Purchase::whereDate('purchase_date', Carbon::today())->sum('total_amount');

    // Profits (Total) - Montant total de tous les achats
    $totalProfit = Purchase::sum('total_amount');

    // Récupérer le montant total des achats par mois depuis la base de données
    $revenuesByMonth = DB::table('purchases')
        ->select(DB::raw('MONTH(purchase_date) as month, SUM(total_amount) as total'))
        ->groupBy(DB::raw('MONTH(purchase_date)'))
        ->orderBy(DB::raw('MONTH(purchase_date)'))
        ->pluck('total', 'month')
        ->toArray();

    // Créer un tableau de 12 mois avec des valeurs par défaut (0 si aucune donnée ce mois-là)
    $revenuesByMonth = $this->fillMissingMonths($revenuesByMonth);

    // Nombre de paiements effectués (status = 'paid')
    $paymentsPaid = Purchase::where('status', 'paid')->count();

    // Nombre de paiements en attente (status != 'paid')
    $paymentsPending = Purchase::where('status', '!=', 'paid')->count();

    // Passer les données à la vue
    return view('dashboard.index', [
        'profitToday' => $profitToday,
        'totalProfit' => $totalProfit,
        'revenuesByMonth' => json_encode(array_values($revenuesByMonth)), // Convertir en tableau de valeurs seulement
        'ordersByMonth' => json_encode(array_values($this->getOrdersByMonth())), // Appel à la méthode pour les commandes par mois
        'paymentsPaid' => $paymentsPaid,
        'paymentsPending' => $paymentsPending,
    ]);
}


    // Fonction pour remplir les mois manquants avec 0
    private function fillMissingMonths($data)
    {
        $filledData = [];

        for ($i = 1; $i <= 12; $i++) {
            $filledData[$i] = $data[$i] ?? 0; // Si le mois n'a pas de valeur, le remplir avec 0
        }

        return $filledData;
    }

    // Fonction pour obtenir le nombre de commandes par mois
    private function getOrdersByMonth()
    {
        $ordersByMonth = DB::table('purchases')
            ->select(DB::raw('MONTH(purchase_date) as month, COUNT(*) as total'))
            ->groupBy(DB::raw('MONTH(purchase_date)'))
            ->orderBy(DB::raw('MONTH(purchase_date)'))
            ->pluck('total', 'month')
            ->toArray();

        return $this->fillMissingMonths($ordersByMonth);
    }
}
