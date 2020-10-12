<?php

namespace App\Http\Controllers\Admin;

use App\GroupProperty;
use App\Http\Controllers\Controller;
use App\Property;
use App\PropertyValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    public function index()
    {
        $groups = GroupProperty::with('properties')->get()->sortBy('sort');

        return view('admin.properties.list', ['groups' => $groups]);
    }

    public function create()
    {
        $groupProperty = GroupProperty::all();

        return view('admin.properties.create', ['groups' => $groupProperty]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'sort' => 'integer',
        ]);

        $data['multiple'] = $request->has('multiple') ? $request->input('multiple') : 0;
        $data['slug'] = str_slug($data['name']);
        $data['type'] = 'S';

        if ($request->has('group'))
        {
            $groupProperty = GroupProperty::find($request->input('group'));
        }
        else
        {
            $groupProperty = GroupProperty::first();
        }

        $property = $groupProperty->properties()->create($data);

        return redirect()->route('admin.properties.index')->with('success', "Свойство с названием $property->name успешно добавлена");
    }


    public function edit($id)
    {
        $property = Property::with('values')->findOrFail($id);
        $groupProperty = GroupProperty::all();

        return view('admin.properties.edit', ['property' => $property, 'groups' => $groupProperty]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'sort' => 'integer',
        ]);

        $property = Property::findOrFail($id);

        $data['multiple'] = $request->has('multiple') ? $request->input('multiple') : 0;
        $data['slug'] = str_slug($data['name']);
        $data['type'] = 'S';

        if ($request->has('group') && GroupProperty::find($request->input('group')))
            $data['group_id'] = $request->input('group');

        $property->update($data);

        if (!empty($request->values))
        {
            DB::transaction(function() use ($request, $id)
            {
                foreach ($request->values as $valueIndex => $value)
                {
                    if (!empty($value['value']))
                        PropertyValue::updateOrCreate(['id' => $valueIndex], ['value' => $value['value'], 'sort' => $value['sort'], 'property_id' => $id]);
                    else
                        PropertyValue::destroy($valueIndex);
                }
            });
        }

        return redirect()->route('admin.properties.index')->with('success', "Свойство с названием $property->name успешно обновлено");
    }

    public function destroy($id)
    {
        $property = Property::findOrFail($id);

        Property::destroy($id);

        return redirect()->route('admin.properties.index')->with('success', "Свойство с названием $property->name успешно удалено!");
    }
}
