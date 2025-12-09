namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    // Tampilkan dashboard + todo list
    public function index()
    {
        $todos = Todo::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('todos'));
    }

    // Simpan todo baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'due_date' => 'nullable|date'
        ]);

        Todo::create([
            'title' => $request->title,
            'due_date' => $request->due_date,
            'is_done' => false,
        ]);

        return redirect()->back();
    }

    // Toggle status centang
    public function toggle($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->is_done = !$todo->is_done;
        $todo->save();

        return redirect()->back();
    }

    // Hapus todo
    public function delete($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect()->back();
    }
}
