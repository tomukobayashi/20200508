<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request)
    {
       $hasItems = Person::has('board')->get();
       $noItems = Person::doesntHave('board')->get();
       $param = ['hasItems' => $hasItems, 'noItems' => $noItems];
       return view('person.index', $param);
    }
    

   public function find(Request $request)
    {
        return view('person.find',['input' => '']);
    }

    public function search(Request $request)
    {
        //名前
        // $item = Person::nameEqual($request->input)->first();
        // $param = ['input' => $request->input, 'item' => $item];
        // return view('person.find', $param);

        //〇〇以上〇〇以下
        $min = $request->input * 1;
        $max = $min + 10;
        $item = Person::ageGreaterThan($min)->ageLessThan($max)->first();
        $param = ['input' => $request->input, 'item' => $item];
        return view('person.find', $param);
    }

    //追加
    public function add(Request $request)
    {
         return view('person.add');
    }

    public function create(Request $request)
    {
        $this->validate($request, Person::$rules);
        $person = new Person;
        $form = $request->all();
        unset($form['_token']);
        $person->timestamps = false;   
        $person->fill($form)->save();
        return redirect('/person');
    }

    //更新
    public function edit(Request $request)
    {
        $person = Person::find($request->id);
        return view('person.edit', ['form' => $person]);
    }

    public function update(Request $request)
    {
        $this->validate($request, Person::$rules);
        $person = Person::find($request->id);
        $form = $request->all();
        unset($form['_token']);
        $person->timestamps = false;    // 追記
        $person->fill($form)->save();
        return redirect('/person');
    }   


    //削除
    public function delete(Request $request)
    {
         $person = Person::find($request->id);
        return view('person.del', ['form' => $person]);
    }

    public function remove(Request $request)
    {
        Person::find($request->id)->delete();
        return redirect('/person');
    }
}
