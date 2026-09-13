<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Subgroup;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $tab = $request->get('tab', 'groups'); // Pestaña activa ('groups' o 'subgroups')

        // Consulta de Grupos
        $groups = Group::when($search && $tab === 'groups', function ($query, $search) {
            return $query->where('groupname', 'like', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10, ['*'], 'groups_page')
        ->withQueryString();

        // Consulta de Subgrupos con su relación a Grupo
        $subgroups = Subgroup::with('group')
        ->when($search && $tab === 'subgroups', function ($query, $search) {
            return $query->where('subgroupname', 'like', "%{$search}%");
        })
        ->orderBy('id', 'desc')
        ->paginate(10, ['*'], 'subgroups_page')
        ->withQueryString();

        // Para llenar el select al crear/editar Subgrupos
        $allGroups = Group::orderBy('groupname', 'asc')->get();

        return view('groups.index', compact('groups', 'subgroups', 'allGroups', 'search', 'tab'));
    }

    // Guardar Grupo
    public function store(Request $request)
    {
        $request->validate([
            'groupname' => 'required|string|max:255|unique:groups,groupname',
        ]);

        Group::create(['groupname' => $request->groupname]);

        return redirect()->route('groups.index', ['tab' => 'groups'])->with('success', 'Grupo creado exitosamente.');
    }

    // Actualizar Grupo
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'groupname' => 'required|string|max:255|unique:groups,groupname,' . $group->id,
        ]);

        $group->update(['groupname' => $request->groupname]);

        return redirect()->route('groups.index', ['tab' => 'groups'])->with('success', 'Grupo actualizado exitosamente.');
    }

    // Eliminar Grupo
    public function destroy(Group $group)
    {
        if ($group->subgroups()->exists()) {
            return redirect()->route('groups.index', ['tab' => 'groups'])
                ->with('error', 'No se puede eliminar el grupo porque tiene subgrupos vinculados.');
        }

        try {
            $group->delete();
            return redirect()->route('groups.index', ['tab' => 'groups'])->with('success', 'Grupo eliminado correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('groups.index', ['tab' => 'groups'])
                    ->with('error', 'No se puede eliminar este grupo porque está siendo utilizado por otros registros del sistema.');
            }

            return redirect()->route('groups.index', ['tab' => 'groups'])
                ->with('error', 'Ocurrió un error inesperado al intentar eliminar el grupo.');
        }
    }

    // --- MÉTODOS PARA SUBGRUPOS ---

    public function storeSubgroup(Request $request)
    {
        $request->validate([
            'subgroupname' => 'required|string|max:255',
            'groupid'      => 'required|exists:groups,id',
        ]);

        Subgroup::create([
            'subgroupname' => $request->subgroupname,
            'groupid'      => $request->groupid,
        ]);

        return redirect()->route('groups.index', ['tab' => 'subgroups'])->with('success', 'Subgrupo creado exitosamente.');
    }

    public function updateSubgroup(Request $request, Subgroup $subgroup)
    {
        $request->validate([
            'subgroupname' => 'required|string|max:255',
            'groupid'      => 'required|exists:groups,id',
        ]);

        $subgroup->update([
            'subgroupname' => $request->subgroupname,
            'groupid'      => $request->groupid,
        ]);

        return redirect()->route('groups.index', ['tab' => 'subgroups'])->with('success', 'Subgrupo actualizado exitosamente.');
    }

    public function destroySubgroup(Subgroup $subgroup)
    {
        try {
            $subgroup->delete();
            return redirect()->route('groups.index', ['tab' => 'subgroups'])->with('success', 'Subgrupo eliminado correctamente.');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('groups.index', ['tab' => 'subgroups'])
                    ->with('error', 'No se puede eliminar este subgrupo porque está asignado a uno o más materiales/artículos.');
            }

            return redirect()->route('groups.index', ['tab' => 'subgroups'])
                ->with('error', 'Ocurrió un error inesperado al intentar eliminar el subgrupo.');
        }
    }
}