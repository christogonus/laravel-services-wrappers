<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {

    Route::get('/generate', function (){
        return view('generate', [
            'prompts' => \App\Models\Prompt::all()
        ]);
    })->name('generate.index');

    Route::post('/generate', function (\Illuminate\Http\Request $request){

        $attributes = $request->validate([
            'number' => ['required'],
            'prompt_id' => ['required'],
            'niche' => ['required'],
            'product' => ['required'],
            'feature' => ['required', 'string', 'min:10'],
            'feature_image' => ['required', 'string', 'min:10'],
            'cta' => ['required', 'string'],
            'discount' => ['nullable', 'string'],
            'date' => ['nullable', 'string'],
            'link' => ['nullable', 'url'],
        ]);

        $campaign = \App\Models\Campaign::create($attributes);
        $openAi = new \App\Services\Openai();
        $prompt = \App\Models\Prompt::findOrFail($attributes['prompt_id']);
        $team = auth()->user()->team; //current team instance

        $find_variables = array("[NUMBER]", "[NICHE]", "[PRODUCT]", "[FEATURE]", "[FEATURE_IMAGE]", "[CTA]", "[DISCOUNT]", "[DATE]", "[LINK]");

        $replace_values = array($campaign->number, $campaign->niche, $campaign->product, $campaign->feature, $campaign->feature_image, $campaign->cta, $campaign->discount, $campaign->date, $campaign->link);

        $textPromptTemplate = str_replace($find_variables, $replace_values, $prompt->text);
        $imagePromptTemplate = str_replace($find_variables, $replace_values, $prompt->image);

        $textPrompt = $textPromptTemplate . " My organization's name is ". $team->name . '.' . ' add the keyword [END] at the end of each social media post content.';

        $written_content = $openAi->generateText($textPrompt);

        $arr_contents = explode("[END]", $written_content);
        foreach ($arr_contents as $arr_content) {
            if (trim($arr_content) != '') {
                $campaign->posts()->create(['content' => $arr_content]);
            }
        }

        $imagePrompt = "Here is a social media post: " . $arr_contents[0] . " \n\n " . $imagePromptTemplate;

        $url = $openAi->generateImage($imagePrompt);
        $contents = file_get_contents($url);
        $upload_path = 'uploads/' . date('Y') . '/'. date('m').'/'.\Illuminate\Support\Str::random(32) . '.png';

        \Illuminate\Support\Facades\Storage::put($upload_path, $contents);

        foreach ($campaign->posts as $post) {
            $post->update(['images' => $upload_path]);
        }

        return $campaign->posts;

    })->name('generate.store');

});
