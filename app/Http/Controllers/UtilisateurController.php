<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tournoi;
use App\Models\Matchs;
use App\Models\Evenement;
use App\Models\ActiviteEvent;
use App\Models\Personnel;
use App\Models\Famille;
use App\Models\TypeParticipant;
use App\Models\Genre;
use App\Models\Inscription;
use App\Models\Participant;
use App\Models\TypeTournoi;
use App\Models\RepartitionCagnote;
use App\Models\Pronostic;

class UtilisateurController extends Controller
{
    public function Accueil(){
        return view('Utilisateur.PageInfo');
    }
    public function LoginUtilisateur(){
        return view('Utilisateur.LoginUtilisateur');
    }
    public function traitementLogin(Request $req){
        $personnel=Personnel::where('emailperso','=',$req['email'])->where('mdpperso','=',$req['mdp'])->first();
        if($personnel){
            session(['personnel'=> $personnel]); 
            $statut="participant";
            $perso=session()->get('personnel');
            return view('Utilisateur.PageInfo',compact('statut','perso'));
        }
        else{
            $erreur="Email ou mot de passe éroné!";
            return view(
                'Utilisateur.LoginUtilisateur',
                [
                    'erreur' => $erreur,
                    'email' => $req['email'],
                ]
            );
        }     
    }
    //Famille
    public function Famille(){
        $perso=session()->get('personnel');
        $trigramme=$perso->trigramme;
        $statut="participant";
        $famille=Famille::with('Genre')->with('TypeParticipant')->where('trigramme','=',$trigramme)->get();
        $typeparticipant=TypeParticipant::all();
        $genre=Genre::all();
        return view('Utilisateur.Famille',compact('famille','statut','typeparticipant','genre')); 
    }
    public function ajoutFamille(Request $req){
        $perso=session()->get('personnel');
        $trigramme=$perso->trigramme;
        $famille = Famille::create([
            'nomfamille' => $req['nomfamille'],
            'idgenre' => $req['idgenre'],
            'datenaissance' => $req['datenaissance'],
            'idtypeparticipant' => $req['idtypeparticipant'],
            'trigramme' => $trigramme
        ]);
        $url = url('Famille');
        return redirect($url);
    }
    public function updateFamille(Request $req)
    {
        $famille = Famille::find($req['idfamille']);
        $famille->nomfamille = $req['nomfamille'];
        $famille->datenaissance = $req['datenaissance'];
        $famille->idgenre = $req['idgenre'];
        $famille->update();
        $url = url('Famille');
        return redirect($url);    
    }
    public function deleteFamille(){
        $Tournoi = TypeTournoi::find($req['idtypetournoi']);
    }
    public function ListeTournoi(Request $req){
        $route="UDetailTournoi";
        $statut="personnel";
        $query = DB::table('tournoi');
        if ($req['idtypetournoi']) {
            $query->where('idtypetournoi', 'ilike', '%' . $req['idtypetournoi'] . '%');
        }
        $tournois = $query->get();
        $participer=[];
        for ($i=0; $i <count($tournois) ; $i++) { 
            array_push($participer,0);
        }
        $typetournoi=TypeTournoi::all();
        return view('Utilisateur.ListeTournoi',compact('tournois','route','participer','statut','typetournoi'));        
    }
    public function DetailTournoi(Request $req){
        $tournoi = Tournoi::findOrFail($req['id']);
        $matchs=Matchs::with('typeMatch')->with('Equipe1')->with('Equipe2')->where('idtournoi','=',$req['id'])->get();
        return view('Utilisateur.DetailTournoi', compact('tournoi','matchs'));
    }
    public function Pronostic(Request $req){
        $perso=session()->get('personnel');
        $route="UDetailPronostic";
        $statut="participant";
        $participer=[];
        if(isset($req['type']) && $req['type']==2){
            $query = DB::table('v_tournoi_participant');
        }
        else{
            $query = DB::table('tournoi');
        }
        if ($req['idtypetournoi']) {
            $query->where('idtypetournoi', 'ilike', '%' . $req['idtypetournoi'] . '%');
        }
        $tournois = $query->get();
        for ($i=0; $i <count($tournois) ; $i++) { 
            $estParticipant=DB::select('select * from participant where idtournoi = ? and trigramme=?', [$tournois[$i]->idtournoi,$perso->trigramme]);
            if(count($estParticipant)!=0){
                array_push($participer,0);
            }
            else{
                array_push($participer,1);
            }
        }
        $typetournoi=TypeTournoi::all();
        return view('Utilisateur.ListeTournoi',compact('tournois','statut','route','participer','typetournoi'));          
    }
    public function formulaireParticipation($idtournoi,$erreur){
        $statut="participant";
        $tournoi=Tournoi::find($idtournoi);
        $equipes = DB::select('Select * from v_equipe_parTournoi');
        return view('Utilisateur.Paiement',compact('statut','tournoi','equipes','erreur'));  
    }
    public function inscription(Request $req){
        $idtournoi=$req['idtournoi'];
        $perso=session()->get('personnel');
        $participant = Participant::create([
            'trigramme' => $perso->trigramme,
            'idtournoi' => $req['idtournoi'],
            'idequipe1g' => $req['idequipe1g'],
            'idequipe2g' => $req['idequipe2g'],
            'reponsequestion' => $req['reponsequestion']
        ]);
        $url = url('Pronostiquer', ['idtournoi' => $idtournoi]);
        return redirect($url);
    }
    public function DetailPronostic(Request $req){
        $statut="participant";
        $tournoi = Tournoi::findOrFail($req['id']);
        $matchs=Matchs::with('typeMatch')->with('Equipe1')->with('Equipe2')->where('idtournoi','=',$req['id'])->get();
        return view('Utilisateur.DetailTournoi', compact('tournoi','matchs','statut'));       
    }
    public function Pronostiquer($idtournoi){
        $statut="participant";
        $perso=session()->get('personnel');
        $participant=Participant::where('idtournoi','=',$idtournoi)->where('trigramme','=',$perso->trigramme)->first();
        $idparticipant=$participant->idparticipant;
        $tournoi =Tournoi::findOrFail($idtournoi);
        $matchs= DB::select('Select * from v_match where idtournoi=? and idparticipant=? order by datematch asc',[$idtournoi,$idparticipant]);
        $cagnote=RepartitionCagnote::where('idtournoi','=',$idtournoi)->first();
        $montantCagnote=Participant::where('idtournoi','=',$idtournoi)->get();
        $classements=[];
        foreach($matchs as $match){
            $classement=DB::select('select ROW_NUMBER() OVER (ORDER BY total DESC) AS numligne,c.*,trigramme from classement c join participant p on c.idparticipant=p.idparticipant where idmatch=? order by total desc limit 5',[$match->idmatch]);
            $classements[$match->idmatch] = $classement;
        }
        $Point=DB::table('v_point_partournoi')->where('idtournoi','=',$idtournoi)->where('idparticipant','=',$idparticipant)->first();
        $classementGlobal=DB::select('select ROW_NUMBER() OVER (ORDER BY finale DESC) AS numligne,trigramme,v.* from v_pointFinal v join participant p on v.idparticipant=p.idparticipant where v.idtournoi=? order by finale desc limit 5',[$idtournoi]);
        return view('Utilisateur.Pronostic', compact('Point','montantCagnote','cagnote','idparticipant','tournoi','matchs','classements','classementGlobal','statut'));       
    }
    public function ajoutPronostic(Request $req,$idparticipant,$idtournoi){
        $statut="participant";
        $pronostic = Pronostic::create([
            'idmatch' => $req['idmatch'],
            'idparticipant' => $idparticipant,
            'prono1' => $req['prono1'],
            'prono2' => $req['prono2'],
            'datepronostic' => "now()",
        ]);
        $url = url('Pronostiquer', ['idtournoi' => $idtournoi]);
        return redirect($url);
    }


    public function ListeEvent(){
        $route="UDetailEvent";
        $evenement=Evenement::with('Lieu')->get();
        return view('Utilisateur.ListeEvent',compact('evenement','route'));            
    }
    public function DetailEvent(Request $req){
        $statut="personnel";
        $evenement=Evenement::with('Lieu')->findOrFail($req['id']);
        $activite=ActiviteEvent::with('Evenement')->with('Activite')->where('idevenement','=',$req['id'])->get();
        return view('Utilisateur.DetailEvent',compact('evenement','activite','statut'));
    }

    public function Evenement(){
        $statut="participant";
        $route="UDetailEvenement";
        $evenement=Evenement::with('Lieu')->get();
        return view('Utilisateur.ListeEvent',compact('evenement','statut','route'));  
    }
    public function DetailEvenement(Request $req){
        $perso=session()->get('personnel');
        $trigramme=$perso->trigramme;
        $statut="participant";
        $testParticipation=Inscription::whereNull('idfamille')->where('trigramme','=',$trigramme)->first();
        $estInscrit=1;
        if(isset($testParticipation)){
            $estInscrit=0;
        }
        $evenement=Evenement::with('Lieu')->findOrFail($req['id']);
        $famille=Famille::where('trigramme','=',$trigramme)->get();
        $activite=ActiviteEvent::with('Evenement')->with('Activite')->where('idevenement','=',$req['id'])->get();
        return view('Utilisateur.DetailEvent',compact('estInscrit','evenement','activite','statut','famille'));
    }
    public function minscrire(Request $req){
        $perso=session()->get('personnel');
        $trigramme=$perso->trigramme; 
        $inscription = Inscription::create([
            'dateinscription' => now(),
            'idactiviteevent' => $req['idactiviteevent'],
            'trigramme' => $trigramme,
            'idfamille' => null
        ]); 
        return redirect()->back();     
        
    }
    public function inscriptionfamille(Request $req){
        $perso=session()->get('personnel');
        $trigramme=$perso->trigramme;
        $participation=Inscription::where('trigramme','=',$trigramme)->where('idfamille','=',$req['idfamille'])->first();
        if(isset($participation)){
            echo "Déja inscrit";
        }
        else{
            $inscription = Inscription::create([
                'dateinscription' => now(),
                'idactiviteevent' => $req['idactiviteevent'],
                'trigramme' => $trigramme,
                'idfamille' => $req['idfamille']
            ]);
            return redirect()->back(); 
        }
    }
    public function testEquipe(){
        //Invariables
        $dureeTotalHeure=4;
        $dureeTotalMinute=$dureeTotalHeure*60;
        $nbrInscrit=151;
        $nbrTerrain=4;

        //Variables
        $dureeMatch=30;
        $nbrMatchPossible=($dureeTotalMinute/$dureeMatch)*$nbrTerrain;
        $nbrJoueur_Equipe=7;
        $nbrMatch=intval($nbrInscrit/($nbrJoueur_Equipe*2));
        $reste=$nbrInscrit%($nbrJoueur_Equipe*2);
        echo $reste;
    }
   /* public function creerEquipe($idevenement){
        $activiteEvent=ActiviteEvent::where('idevenement','=',$idevenement)->get();
        foreach ($activiteEvent as $acte) {
            $nbrJoueur=$acte->nbjoueurparequipe;
            $inscription=DB::select('select * from inscriptionactivite where idactiviteevent = ? order by idgenre,age desc', [$acte->idactiviteevent]);
            for ($i=0; $i <$nbrJoueur ; $i++) { 
                $nomEquipe="Equipe".$i+1;
                $equipeactivite = EquipeActivite::create([
                    'nomequipe' => 'nomEquipe',
                    'idactiviteevent' => $acte->idactiviteevent,
                    'idinscription' => $inscription[$i]->idinscription
                ]);
            }
        }
    }*/

}