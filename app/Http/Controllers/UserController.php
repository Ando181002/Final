<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Helpers\PasswordUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\MonEmail;
use App\Models\Tournoi;
use App\Models\Matchs;
use App\Models\Personnel;
use App\Models\Compte;
use App\Models\Participant;
use App\Models\Pronostic;
use Firebase\JWT\JWT;

class UserController extends Controller
{
    public function envoyerEmail($message)
    {
        $name="ASOM";
        $email="rakotoarisoatendry13@gmail.com";
        $subject="Renvoie de mot de passe temporaire";
        Mail::to("afalimanantsoa@gmail.com")->send(new MonEmail($name,$email,$subject,$message));
    }

    public function Accueil(){
        $statut="personnel";
        return view('Personnel.PageInfo',compact('statut'));
    }
    public function ListeTournoi(){
        $tournois=Tournoi::with('typeTournoi')->get();
        $statut="personnel";
        return view('Personnel.ListeTournoi',compact('tournois',"statut"));        
    }
    public function DetailTournoi(Request $req){
        $comptee=session()->get('compte');
        $tournoi = Tournoi::findOrFail($req['id']);
        $statut=$req['statut'];
        $participer="Oui";
        if($req['statut']=="participant"){
            $idcompte=session()->get('idcompte');
            $participation=Participant::where('idtournoi','=',$req['id'])->where('idcompte','=',$idcompte)->get();
            if(count($participation)!=0){
                $participer="Non";
            }
            else{
                $participer="Oui";
            }
        }
        $matchs=Matchs::with('typeMatch')->with('Equipe1')->with('Equipe2')->where('idtournoi','=',$req['id'])->get();
        return view('Personnel.DetailTournoi', compact('tournoi','matchs','statut','participer','comptee'));
    }
    public function LoginNouveau(){
        $statut="personnel";
        return view('Personnel.LoginNouveau',compact('statut'));
    }
    /*public function traitementLogin(Request $req){
        $personnel=Personnel::where('emailperso','=',$req['email'])->where('mdpperso','=',$req['mdp'])->first();
        if($personnel){
            $secret_key = 'ORL57bjrJD3ORxl1pIvlk4aMZzh21VtXnrelmmCkpVQlhx8n1aXErJiaEpEQveMt';
            $payload = array(
                "trigramme" => $personnel->trigramme,
                "nom" => $personnel->nom,
                "emailperso" => $personnel->emailperso,
                "telephone" => $personnel->telephone,
                "idgenre" => $personnel->idgenre,
                "datenaissance" => $personnel->datenaissance,
            );
            $token = JWT::encode($payload, $secret_key, 'HS256');
            $cookie = cookie('jwt_token', $token, 60);
            $statut="participant";
            $comptee=$personnel;
            return view('Personnel.PageInfo',compact('comptee','statut'))->withCookie($cookie);
           /* session(['idpersonnel'=> $personnel[0]['idpersonnel']]); 
            $idpersonnel=session()->get('idpersonnel');
            $statut="participant";
            $comptee=$personnel;
            return view('Personnel.PageInfo',compact('comptee','statut'))->withCookie($cookie);
        }
        else{
            return response()->json(['message' => 'Erreur d\'authentification'], 401);
            /*$erreur="Email ou mot de passe éroné!";
            return view(
                'Personnel.LoginNouveau',
                [
                    'erreur' => $erreur,
                    'email' => $req['email'],
                ]
            );
        }     
    }*/
    public function traitementLogin(Request $req){
        $dateActuelle=now();
        $dateExpiration=$dateActuelle->addHours(24);
        $personnel=Personnel::where('emailperso','=',$req['email'])->where('mdpperso','=',$req['mdp'])->get();
        if(count($personnel)!=0){
            $mdp=PasswordUtils::generateTemporaryPassword();
            $perso=Personnel::find($personnel[0]['trigramme']);
            $compte = Compte::create([
                'trigramme' => $perso->trigramme,
                'nom' => $perso->nom,
                'telephone' => $perso->telephone,
                'email' => $perso->emailperso,
                'mdp' => $mdp,
                'expirationmdp' => $dateExpiration
            ]);
            $this->envoyerEmail($mdp);
            $lastCompte = DB::select('Select * from compte order by idcompte desc limit 1');
            $idcompte=$lastCompte[0]->idcompte;
            $statut="personnel";
            return view('Personnel.reinitialisationMdp',compact('idcompte','statut'));
        }
        else{
            $erreur="Email ou mot de passe éroné!";
            return view(
                'Personnel.LoginNouveau',
                [
                    'erreur' => $erreur,
                    'email' => $req['email'],
                ]
            );
        }     
    }
    public function reinitialiser(Request $req){
        if($req['nouveau']==$req['confirmation']){
            $compte = Compte::find($req['idcompte']);
            $compte->mdp=$req['nouveau'];
            $compte->expirationmdp=null;
            $compte->update();
            $statut="personnel";
            return view('Personnel.LoginParticipant',compact('statut'));
        }
        else{
            echo "tsy mitovy";
        }
    }
    public function LoginParticipant(){
        $statut="personnel";
        return view('Personnel.LoginParticipant',compact('statut'));
    }
    public function traitementParticipant(Request $req){
        $compte=Compte::where('trigramme','=',$req['trigramme'])->where('mdp','=',$req['mdp'])->get();
        if(count($compte)!=0){
            session(['compte'=> $compte[0]]);
            $comptee=session()->get('compte');
            session(['idcompte'=> $compte[0]['idcompte']]);
            $idcompte=session()->get('idcompte');
            $tournois=Tournoi::with('typeTournoi')->get();
            $statut="participant";
            return view('Personnel.ListeTournoi',compact('tournois','idcompte','statut','comptee'));
        }
        else{
            echo "Tsy ao";
        }       
    }
    public function logoutParticipant(){
        session()->flush();
        return redirect('/');        
    }
    public function participation(Request $req){
        $idcompte=session()->get('idcompte');
        $comptee=session()->get('compte');
        $perso=Compte::find($idcompte);
        $statut="participant";
        $tournoi=Tournoi::find($req['id']);
        $equipes = DB::select('Select * from v_equipe_parTournoi');
        return view('Personnel.Paiement',compact('perso','statut','tournoi','equipes','comptee'));        
    }
    public function inscription(Request $req){
        $idtournoi=$req['idtournoi'];
        $participant = Participant::create([
            'idcompte' => session()->get('idcompte'),
            'idtournoi' => $req['idtournoi'],
            'idequipe1g' => $req['idequipe1g'],
            'idequipe2g' => $req['idequipe2g'],
            'reponsequestion' => $req['reponsequestion']
        ]);
        echo "tafiditra";
    }

    public function MesParis(){
        $idcompte=session()->get('idcompte');
        $comptee=session()->get('compte');
        $statut="participant";
        $tournois=DB::select('select p.idcompte,p.idparticipant,t.*from tournoi t join participant p on t.idtournoi=p.idtournoi where idcompte=?',[$idcompte]);
        return view('Personnel.MesParis',compact('statut','tournois','comptee'));
    }

    public function Pronostic($idtournoi,$idparticipant,$statut){
        $comptee=session()->get('compte');
        $tournoi = Tournoi::findOrFail($idtournoi);
        $matchs=  DB::select('Select * from v_match where idtournoi=? and idparticipant=? order by datematch asc',[$idtournoi,$idparticipant]);
        $cagnote=DB::select('select * from v_repartitionCagnote where idtournoi = ?', [$idtournoi]);
        $classements=[];
        foreach($matchs as $match){
            $classement=DB::select('select ROW_NUMBER() OVER (ORDER BY total DESC) AS numligne,* from classement where idmatch=? order by total desc limit 5',[$match->idmatch]);
            $classements[$match->idmatch] = $classement;
        }
        $Point=DB::select('select * from v_point_parTournoi where idtournoi = ? and idparticipant=?', [$idtournoi,$idparticipant]);
        $totalPoint=$Point[0]->total;
        $classementGlobal=DB::select('select ROW_NUMBER() OVER (ORDER BY finale DESC) AS numligne,* from v_pointFinal where idtournoi=? order by finale desc limit 5',[$idtournoi]);
        return view('Personnel.Pronostic', compact('idparticipant','tournoi','matchs','classements','classementGlobal','statut','cagnote','totalPoint','comptee'));       
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
        $url = url('Pronostic', ['idparticipant' => $idparticipant, 'idtournoi' => $idtournoi, 'statut' => $statut]);
        return redirect($url);
    }

    public function profil(){
        $statut="participant";
        $comptee=session()->get('compte');
        return view('Personnel.Profil',compact('statut','comptee'));
    }
}