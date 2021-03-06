<?php

namespace App\Http\Controllers;

use App\Marca;
use App\Produto;
use Auth;
use Illuminate\Http\Request;
use Session;

class ProdutosController extends Controller {
	public function index() {

		$search = \Request::get('search'); //<-- we use global request to get the param of URI
		$produtos = Produto::where('nome', 'like', '%' . $search . '%')->orderBy('id', 'asc')->with('marca')->get();

		return view('produtos.index', ['produtos' => $produtos]);
	}

	public function show($id) {
		//
		$produto = Produto::with('marca')->findOrFail($id);
		return view('produtos.show', compact('produto'));
	}

	public function create() {
		if (Auth::guest() or !Auth::user()->admin) {
			return redirect('/produtos')
				->with('error', 'Acesso negado');

		}
		$marcas = Marca::lists('nome', 'id');
		return view('produtos.create', compact('marcas'));
	}

	public function store(Request $request) {
		$this->validate($request, [
			'nome' => 'required',
			'descricao' => 'required',
			'quantidade' => 'required|numeric|min:1',
			'preco' => 'required|numeric',
			'foto' => 'required',
			'marca_id' => 'required',
		]);

		$input = $request->all();
		Produto::create($input);

		Session::flash('flash_message', 'Produto criado com sucesso!');

		return redirect()->back();
	}

	public function edit($id) {
		if (Auth::guest() or !Auth::user()->admin) {
			return redirect('/produtos')
				->with('error', 'Acesso negado');

		}
		$produto = Produto::findOrFail($id);
		$marcas = Marca::lists('nome', 'id');
		return view('produtos.edit', compact('marcas', 'produto'));
	}

	public function update(Request $request, $id) {
		$produto = Produto::findOrFail($id);

		$this->validate($request, [
			'nome' => 'required',
			'descricao' => 'required',
			'quantidade' => 'required|numeric|min:0',
			'preco' => 'required|numeric',
			'foto' => 'required',
			'marca_id' => 'required',
		]);

		$input = $request->all();

		$produto->fill($input)->save();

		Session::flash('flash_message', 'Produto atualizado!');

		return redirect()->back();
	}

	public function destroy($id) {
		$produto = Produto::findOrFail($id);

		$produto->delete();

		Session::flash('flash_message', 'Produto apagado com sucesso!');

		return redirect()->route('produtos.index');
	}

	public function lista() {
		if (Auth::guest() or !Auth::user()->admin) {
			return redirect('/produtos')
				->with('error', 'Acesso negado');

		}
		$search = \Request::get('search'); //<-- we use global request to get the param of URI
		$produtos = Produto::where('nome', 'like', '%' . $search . '%')->orderBy('id', 'asc')->with('marca')->get();

		return view('produtos.lista', ['produtos' => $produtos]);
	}

}
