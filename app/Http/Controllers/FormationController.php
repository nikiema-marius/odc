<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class FormationController extends Controller
{
    /**
     * Affiche la liste des formations.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $formations = Formation::all();
        return view('formations.index', compact('formations'));
    }

    /**
     * Affiche le formulaire d'ajout de formation.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('formations.create');
    }

    /**
     * Enregistre une nouvelle formation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'lieu' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $formation = new Formation();
        $formation->nom = $request->nom;
        $formation->description = $request->description;
        $formation->date = $request->date;
        $formation->heure = $request->heure;
        $formation->lieu = $request->lieu;
        $formation->save();

        return redirect()->route('formations.index')->with('success', 'Formation enregistrée avec succès !');
    }

    /**
     * Affiche la page de modification d'une formation.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Formation $formation)
    {
        return view('formations.edit', compact('formation'));
    }

    /**
     * Met à jour une formation existante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Formation $formation)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'heure' => 'required|date_format:H:i',
            'lieu' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $formation->nom = $request->nom;
        $formation->description = $request->description;
        $formation->date = $request->date;
        $formation->heure = $request->heure;
        $formation->lieu = $request->lieu;
        $formation->save();

        return redirect()->route('formations.index')->with('success', 'Formation mise à jour avec succès !');
    }

    /**
     * Supprime une formation.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Formation $formation)
    {
        $formation->delete();
        return redirect()->route('formations.index')->with('success', 'Formation supprimée avec succès !');
    }

    /**
     * Active ou désactive une formation.
     *
     * @param  \App\Models\Formation  $formation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(Formation $formation)
    {
        $formation->statut = !$formation->statut;
        $formation->save();

        // Générer un code QR si la formation est activée
        if ($formation->statut) {
            $formation->code_qr = QrCode::size(200)->generate(route('presence.scan', $formation->id));
            $formation->save();
        } else {
            $formation->code_qr = null;
            $formation->save();
        }

        return redirect()->route('formations.index')->with('success', 'Statut de la formation mis à jour !');
    }
}