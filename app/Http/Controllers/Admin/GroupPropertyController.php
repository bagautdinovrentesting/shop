<?php

namespace App\Http\Controllers\Admin;

use App\GroupProperty;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GroupPropertyController extends Controller
{
    public function create()
    {
        return view('admin.group_properties.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'sort' => 'integer'
        ]);

        $groupProperty = GroupProperty::create($data);

        return redirect()->route('admin.properties.index')->with('success', "Группа свойств с названием $groupProperty->name успешно добавлена");
    }

    public function edit($id)
    {
        $groupProperty = GroupProperty::findOrFail($id);

        return view('admin.group_properties.edit', ['group' => $groupProperty]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'sort' => 'integer'
        ]);

        $groupProperty = GroupProperty::findOrFail($id);

        $groupProperty->update($data);

        return redirect()->route('admin.properties.index')->with('success', "Группа свойств с названием $groupProperty->name успешно обновлена");
    }

    public function destroy($id)
    {
        $groupProperty = GroupProperty::findOrFail($id);

        //$this->authorize('delete', $product);

        GroupProperty::destroy($id);

        return redirect()->route('admin.properties.index')->with('success', "Группа свойств с названием $groupProperty->name успешно удален!");
    }
}
