<?php

namespace App\Http\Controllers;
use Carbon\Carbon;


use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Adldap;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\PeriodeProno;
use App\Models\TypeTournoi;
use App\Models\TypeMatch;
use App\Models\Equipe;
use App\Models\EquipeTypeTournoi;
use App\Models\Tournoi;
use App\Models\Matchs;
use App\Models\ResultatMatch;
use App\Models\RepartitionCagnote;
use App\Models\Participant;

class AdminController extends Controller
{
    public function inscriptionAdmin(Request $req){
        return Admin::create([
            'email' => $req->input('email'),
            'mdp' => Hash::make($req->input('mdp'))
        ]);
    }

    public function loginAdmin(Request $req){
        $admin=Admin::where('email','=',$req['email'])->where('mdp','=',$req['mdp'])->get();
        if(count($admin)!=0){
            session(['idadmin'=> $admin[0]['idadmin']]); 
            $val=session()->get('idadmin');
            return view('Admin.AccueilAdmin');
        }
        else{
            $erreur="Email ou mot de passe éroné!";
            return view(
                'LoginAdmin',
                [
                    'erreur'  => $erreur,
                    'email' => $req['email']
                ]
            );
        }
    }
    public function logoutAdmin(){
        session()->flush();
        return redirect('/');
    }

    //Periode pronostic
    public function PeriodePronostic(){
        $periode=PeriodeProno::all();
        return view('Admin.PeriodePronostic',compact('periode')); 
    }
    public function ajoutPeriodePronostic(Request $req){
        $periode = PeriodeProno::create([
            'nomperiode' => $req['nomperiode'],
            'datelimite' => $req['datelimite']
        ]);
        $url = url('PeriodePronostic');
        return redirect($url);
    }
    public function updatePeriodePronostic(Request $req)
    {
        $periode = PeriodeProno::find($req['idperiode']);
        $periode->nomperiode = $req['nomperiode'];
        $periode->datelimite = $req['datelimite'];
        $periode->update();
        $url = url('PeriodePronostic');
        return redirect($url);    
    }
    public function deletePeriode(){
        $periode = PeriodeProno::find($req['idperiode']);
    }

    //Type tournoi
    public function TypeTournoi(){
        $typeTournoi=TypeTournoi::all();
        return view('Admin.TypeTournoi',compact('typeTournoi')); 
    }
    public function ajoutTypeTournoi(Request $req){
        $typeTournoi = TypeTournoi::create([
            'nomtypetournoi' => $req['nomtypetournoi'],
            'dureeminute' => $req['duree']
        ]);
        $url = url('TypeTournoi');
        return redirect($url);
    }
    public function updateTypeTournoi(Request $req)
    {
        $typeTournoi = TypeTournoi::find($req['idtypetournoi']);
        $typeTournoi->nomtypetournoi = $req['nomtypetournoi'];
        $typeTournoi->dureeminute = $req['duree'];
        $typeTournoi->update();
        $url = url('TypeTournoi');
        return redirect($url);    
    }
    public function deleteTypeTournoi(){
        $typeTournoi = TypeTournoi::find($req['idtypetournoi']);
    }
   //Type match
    public function TypeMatch(){
        $typematch=TypeMatch::all();
        return view('Admin.TypeMatch',compact('typematch')); 
    }
    public function ajoutTypeMatch(Request $req){
        $typematch = TypeMatch::create([
            'nomtypematch' => $req['nomtypematch']
        ]);
        $url = url('TypeMatch');
        return redirect($url);
    }
    public function updateTypeMatch(Request $req)
    {
        $typematch = TypeMatch::find($req['idtypematch']);
        $typematch->nomtypematch = $req['nomtypematch'];
        $typematch->update();
        $url = url('TypeMatch');
        return redirect($url);    
    }
    public function deleteTypeMatch(){
        $typematch = TypeMatch::find($req['idtypematch']);
    }

    //Equipe
    public function Equipe(){
        $typetournoi=TypeTournoi::all();
        $equipe=Equipe::all();
        return view('Admin.Equipe',compact('typetournoi','equipe')); 
    }
    public function ajoutEquipe(Request $req){
        $image = $req->file('image');
        $resizedImage = Image::make($image->getRealPath())->resize(50, 30);
        $base64_image = base64_encode($resizedImage->encode());
        $equipe = Equipe::create([
            'nomequipe' => $req['nomequipe'],
            'imageequipe' => $base64_image
        ]);
        $getEquipe=DB::select('select * from Equipe order by idequipe desc limit 1');
        $idEquipe=$getEquipe[0]->idequipe;
        $idtypetournoiSelectionnés = $req->input('idtypetournoi', []);
        if (is_array($idtypetournoiSelectionnés) && count($idtypetournoiSelectionnés) > 0) {
            foreach ($idtypetournoiSelectionnés as $idtypetournoi) {
                $equipeTypeTournoi = EquipeTypeTournoi::create([
                    'idequipe' => $idEquipe,
                    'idtypetournoi' => $idtypetournoi,
                ]);
            }
        }
        $url = url('Equipe');
        return redirect($url);
    }
    public function updateEquipe(Request $req)
    {
        $equipe = Equipe::find($req['idequipe']);
        $equipe->nomequipe = $req['nomequipe'];
        $equipe->update();
        $url = url('Equipe');
        return redirect($url);    
    }
    public function deleteEquipe(){
        $typematch = TypeMatch::find($req['idtypematch']);
    }   

    //Tournoi
    public function ajoutTournoi(Request $req){
        $image = $req->file('image');
        $resizedImage = Image::make($image->getRealPath())->resize(298, 169);
        $base64_image = base64_encode($resizedImage->encode());
        $Tournoi = Tournoi::create([
            'nomtournoi' => $req['nomtournoi'],
            'idtypetournoi' => $req['idtypetournoi'],
            'debuttournoi' => $req['debuttournoi'],
            'fintournoi' => $req['fintournoi'],
            'frais' => $req['frais'],
            'question' => $req['question'],
            'description' => $req['description'],
           'imagetournoi' => $base64_image
        ]);
        $ttournoi=DB::select('select * from tournoi order by idtournoi desc');
        $idtournoi=$ttournoi[0]->idtournoi;
        $repartition=RepartitionCagnote::create([
            'rang1' => $req['rang1']/100,
            'rang2' => $req['rang2']/100,
            'rang3' => $req['rang3']/100,   
            'rang4' => $req['rang4']/100,
            'rang5' => $req['rang5']/100, 
            'idtournoi' => $idtournoi
        ]);
        $url = url('Tournoi');
        return redirect($url);
    }
    public function Tournoi(){
        $typetournoi=TypeTournoi::all();
        $equipe=Equipe::all();
        $tournoi=Tournoi::with('TypeTournoi')->get();
        return view('Admin.Tournoi',compact('typetournoi','tournoi','equipe')); 
    }
    public function FicheTournoi($idtournoi){
        $fichetournoi=Tournoi::find($idtournoi);
        $cagnote=RepartitionCagnote::where('idtournoi','=',$idtournoi)->first();
        $idtypetournoi=$fichetournoi->idtypetournoi;
        $equipe=EquipeTypeTournoi::with('Equipe')->where('idtypetournoi','=',$idtypetournoi)->get();
        $typematch=TypeMatch::all();
        $match=Matchs::with('typeMatch')->with('Equipe1')->with('Equipe2')->where('idtournoi','=',$idtournoi)->get();
        $classements=[];
        foreach($match as $key){
            $classement=DB::select('select trigramme,c.*from classement c join participant p on c.idparticipant=p.idparticipant where idmatch=? order by total desc limit 5',[$key->idmatch]);
            $classements[$key->idmatch] = $classement;
        }
        $resultats=[];
        foreach($match as $key){
            $resultat=DB::select('select* from resultatmatch where idmatch=?',[$key->idmatch]);
            $resultats[$key->idmatch] = $resultat;
        }
        $typetournoi=TypeTournoi::all();
        $participant=Participant::where('idtournoi','=',$idtournoi)->get();
        return view('Admin.FicheTournoi',compact('participant','typetournoi','fichetournoi','cagnote','typematch','equipe','match','classements','resultats')); 
    }
    public function UpdateTournoi(Request $req)
    {
        $tournoi = Tournoi::find($req['idtournoi']);
        $tournoi->nomtournoi = $req['nomtournoi'];
        $tournoi->idtypetournoi = $req['idtypetournoi'];
        $tournoi->debuttournoi = $req['debuttournoi'];
        $tournoi->fintournoi = $req['fintournoi'];
        $tournoi->frais = $req['frais'];
        $tournoi->question = $req['question'];
        $tournoi->description = $req['description'];
        $tournoi->update();
        $repartition=RepartitionCagnote::where('idtournoi','=',$req['idtournoi'])->first();
        $repartition->rang1 = $req['rang1'];
        $repartition->rang2 = $req['rang2'];
        $repartition->rang3 = $req['rang3'];
        $repartition->rang4 = $req['rang4'];
        $repartition->rang5 = $req['rang5'];
        $repartition->update();
        $url = url('FicheTournoi', ['idtournoi' => $req['idtournoi']]);
        return redirect($url); 
    }
    public function deleteTournoi(){
        $typematch = TypeMatch::find($req['idtypematch']);
    }  
      //Match
      public function Match(){

        return view('FicheTournoi'); 
    }
    public function ajoutMatch(Request $req,$idtournoi){
        $duree=DB::select('Select dureeminute from tournoi t join typetournoi tt on t.idtypetournoi=tt.idtypetournoi where idtournoi=?',[$req['idtournoi']]);
        $dureematch=$duree[0]->dureeminute;
        $stringDateTime = $req['datematch']; // Votre chaîne de caractères représentant la date et l'heure
        $carbonDateTime = Carbon::parse($stringDateTime);
        $newCarbonDateTime = $carbonDateTime->addMinutes($dureematch);       
        $newDateTime = $newCarbonDateTime->format('Y-m-d\TH:i'); // Format de sortie : "2023-08-16T13:14"       
        $match = Matchs::create([
            'idtournoi' => $idtournoi,
            'idtypematch' => $req['idtypematch'],
            'datematch' => $req['datematch'],
            'finmatch' => $newDateTime,
            'idequipe1' => $req['idequipe1'],
            'idequipe2' => $req['idequipe2'],
            'ptresultat' => $req['ptresultat'],
            'ptscore' => $req['ptscore'],
            'stade' => $req['stade'],
            'statut' => "0"
        ]);
        $url = url('FicheTournoi', ['idtournoi' => $idtournoi]);
        return redirect($url);
    }
    public function ajoutMatchCsv(Request $req,$idtournoi){
        if ($req->hasFile('csv')) {
            $file=$req->file('csv');
            $handle=fopen($file->getPathname(), 'r');
            $table_data=array();
            while(($data=fgetcsv($handle, 0, ';')) !==false) {
                $values=$data;
                $typematch=TypeMatch::Where('nomtypematch',$values[0])->first();
                $datematch=Carbon::createFromFormat('d/m/Y H:i',$values[1])->format('Y-m-d H:i'); 
                $duree=DB::select('Select dureeminute from tournoi t join typetournoi tt on t.idtypetournoi=tt.idtypetournoi where idtournoi=?',[$idtournoi]);
                $dureematch=$duree[0]->dureeminute;
                $datee = Carbon::parse($datematch);
                $finmatch = $datee->addMinutes($dureematch);       
                $finmatch = $finmatch->format('Y-m-d H:i');  
                $equipe1=Equipe::Where('nomequipe',$values[3])->first(); 
                $equipe2=Equipe::Where('nomequipe',$values[4])->first();            
                $table_data[]=[
                    'idtypematch'=> $typematch->idtypematch,
                    'idtournoi'=>$idtournoi,
                    'datematch'=>$datematch,
                    'finmatch'=>$finmatch,
                    'stade'=>$values[2],
                    'idequipe1'=>$equipe1->idequipe,
                    'idequipe2'=>$equipe2->idequipe,
                    'ptresultat'=>$values[5],
                    'ptscore'=>$values[6],
                    'statut'=>1
                ];
            }
            fclose($handle);
            DB::table('matchs')->insert($table_data);
            return redirect()->back()->with('succes','Enregistrer');
        }
        else return redirect()->back()->with('succes','Erreur d enregistrement');      
    }
    public function updateMatch(Request $req,$idtournoi)
    {
        $duree=DB::select('Select dureeminute from tournoi t join typetournoi tt on t.idtypetournoi=tt.idtypetournoi where idtournoi=?',[$req['idtournoi']]);
        $dureematch=$duree[0]->dureeminute;
        $stringDateTime = $req['datematch']; // Votre chaîne de caractères représentant la date et l'heure
        $carbonDateTime = Carbon::parse($stringDateTime);
        $newCarbonDateTime = $carbonDateTime->addMinutes($dureematch);       
        $newDateTime = $newCarbonDateTime->format('Y-m-d\TH:i');
        $match = Matchs::find($req['idmatch']);
        $match->idtournoi = $idtournoi;
        $match->idtypematch = $req['idtypematch'];
        $match->datematch = $newDateTime;
        $match->finmatch = $req['datematch'];
        $match->idequipe1 = $req['idequipe1'];
        $match->idequipe2 = $req['idequipe2'];
        $match->ptresultat = $req['ptresultat'];
        $match->ptscore = $req['ptscore'];
        $match->update();
        $url = url('FicheTournoi', ['idtournoi' => $idtournoi]);
        return redirect($url); 
    }
    public function deleteMatch(){
        $typematch = TypeMatch::find($req['idtypematch']);
    }
    public function ajoutResultatMatch(Request $req,$idtournoi){
        $resultatmatch = ResultatMatch::create([
            'idmatch' => $req['idmatch'],
            'dateresultat' => now(),
            'score1' => $req['score1'],
            'score2' => $req['score2']
        ]);
        $match = Matchs::find($req['idmatch']);
        $match->statut="1";
        $match->update();
        $url = url('FicheTournoi', ['idtournoi' => $idtournoi]);
        return redirect($url); 
    } 
    public function callCodeIgniterHistorique()
    {
        // Spécifiez l'URL de l'API CodeIgniter et l'endpoint
        $apiUrl = 'http://127.0.0.1/OrangeMoney/api/historique?numero=0324567890';
        //$endpoint = '/endpoint';

        // Effectuez une requête GET vers l'API CodeIgniter
        $response = Http::get($apiUrl);
        
        // Vérifiez si la requête a réussi
        if ($response->successful()) {
            // Convertissez la réponse JSON en tableau associatif
            $data = $response->json();
            
            // Traitez les données ici
            return response()->json($data);
        } else {
            // Gérez les erreurs ici
            $statusCode = $response->status();
            return response()->json(['error' => 'Erreur lors de la requête vers l\'API CodeIgniter', 'status_code' => $statusCode], $statusCode);
        }
    
    }   

    public function callCodeIgniterTransfert(Request $req)
    {
        // Créez une instance de client Guzzle
        $client = new Client();

        // URL de l'API CodeIgniter pour la méthode "transfert"
        $apiUrl = 'http://127.0.0.1/OrangeMoney/api/transfert';

        // Données à envoyer à l'API pour la méthode "transfert"
        $data = [
            'numenvoyeur' => '0324567890',
            'numrecepteur' => '0326789012',
            'montant' => '15000000000',
            'objet' => 'Transactions',
            'codesecret' => '1234',
        ];

        try {
            // Effectuez une requête POST vers l'API CodeIgniter pour la méthode "transfert"
            $response = $client->request('POST', $apiUrl, [
                'form_params' => $data,
            ]);

            // Obtenez le contenu de la réponse (au format JSON)
            $apiData = json_decode($response->getBody(), true);

            // Faites quelque chose avec les données reçues de l'API
            return response()->json($apiData);
        } catch (Exception $e) {
            // Gérez les erreurs ici
            return response()->json(['error' => 'Une erreur s\'est produite lors de l\'appel de l\'API CodeIgniter.']);
        }
    }
}

