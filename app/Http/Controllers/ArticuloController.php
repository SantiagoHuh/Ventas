<?php

namespace Ventas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Ventas\Http\Requests\ArticuloFormRequest;
use Ventas\Articulo;
use DB;

class ArticuloController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
  public function index(Request $request)
  {
    if ($request) {
      $query = trim($request->get('searchText'));
      $articulos = DB::table('articulo AS a')
      ->JOIN('categoria as c','a.idcategoria','=','c.idcategoria')
      ->SELECT('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre AS categoria','a.descripcion','a.imagen','a.estado')
      ->WHERE('a.nombre','LIKE','%'.$query.'%')
      ->ORWHERE('a.codigo','LIKE','%'.$query.'%')
      ->ORDERBY('a.idarticulo','asc')
      ->paginate(7);
      return view('almacen.articulo.index',["articulos"=>$articulos,"searchText"=>$query]);
    }
  }
  public function create()
  {
    $categorias=DB::table('categoria')->WHERE('condicion','=','1')->get();
    return view("almacen.articulo.create",["categorias"=>$categorias]);
  }
  public function store(ArticuloFormRequest $request)
  {
    $articulo = new Articulo;
    $articulo->idcategoria=$request->get('idcategoria');
    $articulo->codigo=$request->get('codigo');
    $articulo->nombre=$request->get('nombre');
    $articulo->stock=$request->get('stock');
    $articulo->descripcion=$request->get('descripcion');
    $articulo->estado='Activo';

    if (Input::hasFile('imagen')) {
      $file=Input::file('imagen');
      $file->move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
      $articulo->imagen = $file->getClientOriginalName();
    }
    $articulo->save();
    return Redirect::to('almacen/articulo');
  }
  public function show($id)
  {
    return view("almacen.articulo.show",["articulo"=>Articulo::findOrFail($id)]);
  }
  public function edit($id)
  {
    $articulo=Articulo::findOrFail($id);
    $categorias=DB::table('categoria')->WHERE('condicion','=','1')->get();
    return view("almacen.articulo.edit",["articulo"=>$articulo,"categorias"=>$categorias]);
  }
  public function update(ArticuloFormRequest $request,$id)
  {
    $articulo=Articulo::findOrFail($id);
    $articulo->idcategoria=$request->get('idcategoria');
    $articulo->codigo=$request->get('codigo');
    $articulo->nombre=$request->get('nombre');
    $articulo->stock=$request->get('stock');
    $articulo->descripcion=$request->get('descripcion');

    if (Input::hasFile('imagen')) {
      $file=Input::file('imagen');
      $file->move(public_path().'/imagenes/articulos/',$file->getClientOriginalName());
      $articulo->imagen = $file->getClientOriginalName();
    }
    $articulo->update();
    return Redirect::to('almacen/articulo');
  }
  public function destroy($id)
  {
    $articulo=Articulo::findOrFail($id);
    $articulo->estado='Inactivo';
    $articulo->update();
    return Redirect::to('almacen/articulo');
  }
}
