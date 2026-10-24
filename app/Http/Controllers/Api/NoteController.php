<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class NoteController extends Controller
{
    #[OA\Get(
        path: "/api/notes",
        summary: "Lister toutes les notes (public)",
        tags: ["Notes"],
        responses: [new OA\Response(response: 200, description: "Liste des notes")]
    )]
    public function index()
    {
        return response()->json([
            'notes' => Note::with('user:id,name')->latest()->get(),
        ]);
    }

    #[OA\Get(
        path: "/api/notes/{id}",
        summary: "Voir une note (public)",
        tags: ["Notes"],
        parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
        responses: [
            new OA\Response(response: 200, description: "Note trouvée"),
            new OA\Response(response: 404, description: "Note introuvable"),
        ]
    )]
    public function show(Note $note)
    {
        return response()->json(['note' => $note->load('user:id,name')]);
    }

    #[OA\Post(
        path: "/api/notes",
        summary: "Créer une note",
        tags: ["Notes"],
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["title", "content"],
                properties: [
                    new OA\Property(property: "title", type: "string", example: "Ma première note"),
                    new OA\Property(property: "content", type: "string", example: "Contenu de la note"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Note créée"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note = $request->user()->notes()->create($validated);

        return response()->json(['note' => $note], 201);
    }

    #[OA\Put(
        path: "/api/notes/{id}",
        summary: "Modifier sa note",
        tags: ["Notes"],
        security: [["bearerAuth" => []]],
        parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "title", type: "string", example: "Titre modifié"),
                    new OA\Property(property: "content", type: "string", example: "Contenu modifié"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Note modifiée"),
            new OA\Response(response: 400, description: "Aucune donnée à mettre à jour"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 403, description: "Ce n'est pas votre note"),
            new OA\Response(response: 404, description: "Note introuvable"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Action non autorisée.'], 403);
        }

        $validated = $request->validate([
            'title'   => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
        ]);

        if (empty($validated)) {
            return response()->json(['message' => 'Aucune donnée à mettre à jour.'], 400);
        }

        $note->update($validated);

        return response()->json(['note' => $note]);
    }

    #[OA\Delete(
        path: "/api/notes/{id}",
        summary: "Supprimer sa note",
        tags: ["Notes"],
        security: [["bearerAuth" => []]],
        parameters: [new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))],
        responses: [
            new OA\Response(response: 200, description: "Note supprimée"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 403, description: "Ce n'est pas votre note"),
            new OA\Response(response: 404, description: "Note introuvable"),
        ]
    )]
    public function destroy(Request $request, Note $note)
    {
        if ($note->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Action non autorisée.'], 403);
        }

        $note->delete();

        return response()->json(['message' => 'Note supprimée.']);
    }
}