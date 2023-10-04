<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UtilisateurController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/LoginAdmin', function () {
    return view('Admin.LoginAdmin');
});
Route::POST('loginAdmin', [AdminController::class, 'loginAdmin']);
Route::GET('logoutAdmin', [AdminController::class, 'logoutAdmin']);

//Période de pronostic
Route::GET('PeriodePronostic', [AdminController::class, 'PeriodePronostic']);
Route::POST('addPeriodePronostic', [AdminController::class, 'ajoutPeriodePronostic']);
Route::POST('updatePeriodePronostic',[AdminController::class, 'updatePeriodePronostic']);
Route::POST('deletePeriodePronostic',[AdminController::class, 'deletePeriodePronostic']);

//Type TOURNOI
Route::GET('TypeTournoi', [AdminController::class, 'TypeTournoi']);
Route::POST('addTypeTournoi', [AdminController::class, 'ajoutTypeTournoi']);
Route::POST('updateTypeTournoi',[AdminController::class, 'updateTypeTournoi']);
Route::POST('deleteTypeTournoi',[AdminController::class, 'deleteTypeTournoi']);

//Type MATCH
Route::GET('TypeMatch', [AdminController::class, 'TypeMatch']);
Route::POST('addTypeMatch', [AdminController::class, 'ajoutTypeMatch']);
Route::POST('updateTypeMatch',[AdminController::class, 'updateTypeMatch']);
Route::POST('deleteTypeMatch',[AdminController::class, 'deleteTypeMatch']);

//Equipe
Route::GET('Equipe', [AdminController::class, 'Equipe']);
Route::POST('addEquipe', [AdminController::class, 'ajoutEquipe']);
Route::POST('updateEquipe',[AdminController::class, 'updateEquipe']);
Route::POST('deleteEquipe',[AdminController::class, 'deleteEquipe']);

//Tournoi
Route::GET('Tournoi', [AdminController::class, 'Tournoi']);
Route::GET('FicheTournoi/{idtournoi}', [AdminController::class, 'FicheTournoi']);
Route::POST('addTournoi', [AdminController::class, 'ajoutTournoi']);
Route::POST('/FicheTournoi/updateTournoi',[AdminController::class, 'UpdateTournoi']);
Route::POST('deleteTournoi',[AdminController::class, 'deleteTournoi']);

//Match
Route::GET('Match', [AdminController::class, 'Match']);
Route::POST('/{idtournoi}/addMatch', [AdminController::class, 'ajoutMatch']);
Route::POST('/{idtournoi}/addMatchCsv', [AdminController::class, 'ajoutMatchCsv']);
Route::POST('/{idtournoi}/updateMatch', [AdminController::class, 'updateMatch']);
Route::POST('/{idtournoi}/addResultatMatch', [AdminController::class, 'ajoutResultatMatch']);
Route::POST('deleteMatch',[AdminController::class, 'deleteMatch']);

Route::GET('/', [UserController::class, 'Accueil']);
Route::GET('ListeTournoi', [UserController::class, 'ListeTournoi']);
Route::GET('DetailTournoi', [UserController::class, 'DetailTournoi']);
Route::GET('LoginNouveau', [UserController::class, 'LoginNouveau']);
Route::POST('traitementLogin', [UserController::class, 'traitementLogin']);
Route::POST('reinitialiser',[UserController::class, 'reinitialiser']);
Route::GET('LoginParticipant', [UserController::class, 'LoginParticipant']);
Route::GET('logoutParticipant', [UserController::class, 'logoutParticipant']);
Route::POST('traitementParticipant', [UserController::class, 'traitementParticipant']);
Route::GET('participation', [UserController::class, 'participation']);
Route::POST('inscription', [UserController::class, 'inscription']);
Route::GET('MesParis', [UserController::class, 'MesParis']);
Route::GET('Pronostic/{idtournoi}/{idparticipant}/{statut}', [UserController::class, 'Pronostic']);
Route::POST('/{idparticipant}/{idtournoi}/addPronostic', [UserController::class, 'ajoutPronostic']);
Route::GET('profil', [UserController::class, 'profil']);

//Type Activite
Route::GET('TypeActivite', [EventController::class, 'TypeActivite']);
Route::POST('addtypeactivite', [EventController::class, 'ajoutTypeActivite']);
Route::POST('updateTypeActivite',[EventController::class, 'updateTypeActivite']);
Route::POST('deleteTypeActivite',[EventController::class, 'deleteTypeActivite']);

//Activite
Route::GET('Activite', [EventController::class, 'Activite']);
Route::POST('addActivite', [EventController::class, 'ajoutActivite']);
Route::POST('updateActivite',[EventController::class, 'updateActivite']);
Route::POST('deleteActivite',[EventController::class, 'deleteActivite']);

//Lieu
Route::GET('Lieu', [EventController::class, 'Lieu']);
Route::POST('addLieu', [EventController::class, 'ajoutLieu']);
Route::POST('updateLieu',[EventController::class, 'updateLieu']);
Route::POST('deleteLieu',[EventController::class, 'deleteLieu']);

//Categorie joueur
Route::GET('CategorieJoueur', [EventController::class, 'CategorieJoueur']);
Route::POST('addCategorieJoueur', [EventController::class, 'ajoutCategorieJoueur']);
Route::POST('updateCategorieJoueur',[EventController::class, 'updateCategorieJoueur']);
Route::POST('deleteCategorieJoueur',[EventController::class, 'deleteCategorieJoueur']);

//Evenement
Route::GET('Evenement', [EventController::class, 'Evenement']);
Route::GET('FicheEvenement/{idevenement}', [EventController::class, 'FicheEvenement']);
Route::POST('addEvenement', [EventController::class, 'ajoutEvenement']);
Route::POST('updateEvenement',[EventController::class, 'updateEvenement']);
Route::POST('deleteEvenement',[EventController::class, 'deleteEvenement']);

//Activite evenement
Route::GET('ActiviteEvent', [EventController::class, 'Match']);
Route::POST('/{idevenement}/addActiviteEvent', [EventController::class, 'ajoutActiviteEvent']);
Route::POST('/{idevenement}/updateActiviteEvent', [EventController::class, 'updateActiviteEvent']);
Route::POST('/{idevenement}/addResultatActiviteEvent', [EventController::class, 'ajoutResultatActiviteEvent']);
Route::POST('deleteActiviteEvent',[EventController::class, 'deleteActiviteEvent']);

//Type Participant
Route::GET('TypeParticipant', [EventController::class, 'TypeParticipant']);
Route::POST('addTypeParticipant', [EventController::class, 'ajoutTypeParticipant']);
Route::POST('updateTypeParticipant',[EventController::class, 'updateTypeParticipant']);
Route::POST('deleteTypeParticipant',[EventController::class, 'deleteTypeParticipant']);

Route::GET('ListeEvent', [EventController::class, 'ListeEvent']);
Route::GET('DetailEvent', [EventController::class, 'DetailEvent']);


// tena izy
Route::GET('/AccueilUtilisateur', [UtilisateurController::class, 'Accueil']);
Route::GET('UListeTournoi', [UtilisateurController::class, 'ListeTournoi']);
Route::GET('UDetailTournoi', [UtilisateurController::class, 'DetailTournoi']);
Route::GET('UPronostic', [UtilisateurController::class, 'Pronostic']);
Route::GET('participerPronostic/{idtournoi}/{erreur}', [UtilisateurController::class, 'formulaireParticipation']);
Route::POST('inscriptionProno', [UtilisateurController::class, 'inscription']);
Route::GET('UDetailPronostic', [UtilisateurController::class, 'DetailPronostic']);
Route::GET('Pronostiquer/{idtournoi}', [UtilisateurController::class, 'Pronostiquer']);
Route::POST('/{idparticipant}/{idtournoi}/addUPronostic', [UtilisateurController::class, 'ajoutPronostic']);
Route::GET('UListeEvent', [UtilisateurController::class, 'ListeEvent']);
Route::GET('UDetailEvent', [UtilisateurController::class, 'DetailEvent']);
Route::GET('LoginUtilisateur', [UtilisateurController::class, 'LoginUtilisateur']);
Route::POST('UtraitementLogin', [UtilisateurController::class, 'traitementLogin']);
Route::GET('Famille', [UtilisateurController::class, 'Famille']);
Route::POST('addFamille', [UtilisateurController::class, 'ajoutFamille']);
Route::POST('updateFamille',[UtilisateurController::class, 'updateFamille']);
Route::POST('deleteFamille',[UtilisateurController::class, 'deleteFamille']);
Route::GET('UEvent', [UtilisateurController::class, 'Evenement']);
Route::GET('UDetailEvenement', [UtilisateurController::class, 'DetailEvenement']);
Route::GET('minscrire', [UtilisateurController::class, 'minscrire']);
Route::POST('inscriptionfamille', [UtilisateurController::class, 'inscriptionfamille']);
Route::GET('testEquipe', [UtilisateurController::class, 'testEquipe']);








Route::GET('testapi', [AdminController::class, 'callCodeIgniterTransfert']);
Route::POST('ldap', [AdminController::class, 'ldap']);

