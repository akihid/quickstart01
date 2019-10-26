<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Task;
use Illuminate\Http\Request;

// タスク一覧表示
Route::get('/', function(){

		$tasks = Task::orderBy('created_at', 'asc')->get();
    return view('tasks', [
			'tasks' => $tasks
		]);
});

// タスク追加
Route::post('/task', function(Request $request){
// Request $requestという記述でPOSTデータを取得する
	$validator = Validator::make($request->all(),[
		'name' => 'required|max:255',
	]);
	if ($validator->fails()){
		return redirect('/')
			->withInput()
			->withErrors($validator);
	}

	//　タスク作成処理
	$task = new Task;
	$task->name = $request->name;
	$task->save();

	return redirect('/');
});

// タスク削除
Route::delete('/task/{task}', function(Task $task){
		//{task}という処理で消すタスクを特定しfunction(Task $task)に送る
		$task->delete();

		return redirect('/');
});