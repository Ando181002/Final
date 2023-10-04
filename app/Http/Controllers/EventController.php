<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\TypeActivite;
use App\Models\Activite;
use App\Models\Lieu;
use App\Models\CategorieJoueur;
use App\Models\Evenement;
use App\Models\ActiviteEvent;
use App\Models\TypeParticipant;

class EventController extends Controller
{
    //Type activite
    public function TypeActivite(){
        $typeactivite=TypeActivite::all();
        return view('Event.TypeActivite',compact('typeactivite')); 
    }
    public function ajoutTypeActivite(Request $req){
        $typeactivite = TypeActivite::create([
            'nomtypeactivite' => $req['nomtypeactivite'],
        ]);
        $url = url('TypeActivite');
        return redirect($url);
    }
    public function updateTypeActivite(Request $req)
    {
        $typeactivite = TypeActivite::find($req['idtypeactivite']);
        $typeactivite->nomtypeactivite = $req['nomtypeactivite'];
        $typeactivite->update();
        $url = url('TypeActivite');
        return redirect($url);    
    }
    public function deleteTypeActivite(){
        $typeTournoi = TypeTournoi::find($req['idtypetournoi']);
    }
    //Type activite
    public function Activite(){
        $activite=Activite::with('TypeActivite')->get();
        $typeactivite=TypeActivite::all();
        return view('Event.Activite',compact('activite','typeactivite')); 
    }
    public function ajoutActivite(Request $req){
        $activite = Activite::create([
            'idtypeactivite' => $req['idtypeactivite'],
            'nomactivite' => $req['nomactivite'],
        ]);
        $url = url('Activite');
        return redirect($url);
    }
    public function updateActivite(Request $req)
    {
        $activite = Activite::find($req['idactivite']);
        $activite->nomactivite = $req['nomactivite'];
        $activite->update();
        $url = url('Activite');
        return redirect($url);    
    }
    public function deleteActivite(){
        $Tournoi = TypeTournoi::find($req['idtypetournoi']);
    }

    //Lieu
    public function Lieu(){
        $lieu=Lieu::all();
        return view('Event.Lieu',compact('lieu')); 
    }
    public function ajoutLieu(Request $req){
        $image = $req->file('image');
        $base64_image = base64_encode(file_get_contents($image));
        $Lieu = Lieu::create([
            'latitude' => $req['latitude'],
            'longitude' => $req['longitude'],
            'nomlieu' => $req['nomlieu'],
            'imagelieu' => $base64_image
        ]);
        $url = url('Lieu');
        return redirect($url);
    }
    public function updateLieu(Request $req)
    {
        $Lieu = Lieu::find($req['idlieu']);
        $Lieu->nomlieu = $req['nomlieu'];
        $Lieu->latitude = $req['latitude'];
        $Lieu->longitude = $req['longitude'];
        $Lieu->update();
        $url = url('Lieu');
        return redirect($url);    
    }
    public function deleteLieu(){
        $Tournoi = TypeTournoi::find($req['idtypetournoi']);
    }
    //CategorieJoueur
    public function CategorieJoueur(){
        $categorie=CategorieJoueur::all();
        return view('Event.CategorieJoueur',compact('categorie')); 
    }
    public function ajoutCategorieJoueur(Request $req){
        $categorie = CategorieJoueur::create([
            'nomcategorie' => $req['nomcategorie'],
            'agemin' => $req['agemin'],
            'agemax' => $req['agemax'],
        ]);
        $url = url('CategorieJoueur');
        return redirect($url);
    }
    public function updateCategorieJoueur(Request $req)
    {
        $categorie = CategorieJoueur::find($req['idcategorie']);
        $categorie->nomcategorie = $req['nomcategorie'];
        $categorie->agemin = $req['agemin'];
        $categorie->agemax = $req['agemax'];
        $categorie->update();
        $url = url('CategorieJoueur');
        return redirect($url);    
    }
    public function deleteCategorieJoueur(){
        $Tournoi = TypeTournoi::find($req['idtypetournoi']);
    }
    //Evenement
    public function Evenement(){
        $evenement=Evenement::with('Lieu')->get();
        $lieu=Lieu::all();
        return view('Event.Evenement',compact('evenement','lieu')); 
    }
    public function FicheEvenement($idevenement){
        $ficheevent=Evenement::with('Lieu')->find($idevenement);
        $typeactivite=TypeActivite::all();
        $activitee=Activite::all();
        $lieu=Lieu::all();
        $activiteevent=ActiviteEvent::with('Evenement')->with('Activite')->where('idevenement','=',$idevenement)->get();
        return view('Event.FicheEvent',compact('ficheevent','lieu','activiteevent','typeactivite','activitee')); 
    }
    public function ajoutEvenement(Request $req){
        $event = Evenement::create([
            'titre' => $req['titre'],
            'descri' => $req['descri'],
            'fininscription' => $req['fininscription'],
            'dateevent' => $req['dateevent'],
            'idlieu' => $req['idlieu'],
        ]);
        $url = url('Evenement');
        return redirect($url);
    }
    public function updateEvenement(Request $req)
    {
        $evenement = Evenement::find($req['idevenement']);
        $evenement->titre = $req['titre'];
        $evenement->descri = $req['descri'];
        $evenement->fininscription = $req['fininscription'];
        $evenement->dateevent = $req['dateevent'];
        $evenement->idlieu = $req['idlieu'];
        $evenement->update();
        $url = url('Evenement');
        return redirect($url);    
    }
    public function deleteEvenement(){
        $Tournoi = TypeTournoi::find($req['idtypetournoi']);
    }

    //ActiviteEvent
    public function ajoutActiviteEvent(Request $req,$idevenement){
        $event = ActiviteEvent::create([
            'idactivite' => $req['idactivite'],
            'nbjoueurparactivite' => $req['nbjoueurparactivite'],
            'idevenement' => $idevenement
        ]);
        $url = url('FicheEvenement', ['idevenement' => $idevenement]);
        return redirect($url);
    }
    public function updateActiviteEvent(Request $req,$idevenement)
    {
        $activiteevent = ActiviteEvent::find($req['idactiviteevent']);
        $activiteevent->idactivite = $req['idactivite'];
        $activiteevent->nbjoueurparactivite = $req['nbjoueurparactivite'];
        $activiteevent->idevenement = $idevenement;
        $activiteevent->update();
        $url = url('FicheEvenement', ['idevenement' => $idevenement]);
        return redirect($url);    
    }

    //Type participant
    public function TypeParticipant(){
        $typeparticipant=TypeParticipant::all();
        return view('Event.TypeParticipant',compact('typeparticipant')); 
    }
    public function ajoutTypeParticipant(Request $req){
        $typeparticipant = TypeParticipant::create([
            'nomtypeparticipant' => $req['nomtypeparticipant'],
        ]);
        $url = url('TypeParticipant');
        return redirect($url);
    }
    public function updateTypeParticipant(Request $req)
    {
        $typeparticipant = TypeParticipant::find($req['idtypeparticipant']);
        $typeparticipant->nomtypeparticipant = $req['nomtypeparticipant'];
        $typeparticipant->update();
        $url = url('TypeParticipant');
        return redirect($url);    
    }
    public function deleteTypeParticipant(){
        $typeTournoi = TypeTournoi::find($req['idtypetournoi']);
    }

    public function ListeEvent(){
        $evenement=Evenement::with('Lieu')->get();
        $statut="personnel";
        return view('Event.ListeEvent',compact('evenement',"statut"));            
    }
    public function DetailEvent(Request $req){
            $statut="personnel";
            $evenement=Evenement::with('Lieu')->findOrFail($req['id']);
            $activite=ActiviteEvent::with('Evenement')->with('Activite')->where('idevenement','=',$req['id'])->get();
            return view('Event.DetailEvent',compact('statut','evenement','activite'));
    }
}