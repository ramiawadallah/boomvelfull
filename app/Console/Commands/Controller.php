<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Controller extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:controller {name} {path=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command Used To Set Controller With Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function createPath($path=null)
    {
        if (!is_null($path)) 
        {
            $path = str_replace('\\', '/', $path);
            $pathArray = explode('/', $path);

            $d ='';
            $paths = [];
            foreach ($pathArray as $key => $dir) {
                $d .= $key == 0 ? $dir : '/'.$dir;
                $paths[] = $d;
            }
            foreach ($paths as $folder) 
            {
                if (!is_dir($folder)) 
                {
                    @mkdir($folder);
                }
            }
        }
    }

     public function Controller($data)
     {
        $path = $this->argument('path') == 'null' ? null : $this->argument('path').'\\';
        $controller_path = app_path('Http/Controllers/'.$data['controller'].'.php');
        $path = str_replace('/', '\\', $path);
        // $this->createPath($path);
        $myfile = fopen($controller_path,'w');
        $txt = "Controller\n";
        fwrite($myfile, $txt);
        fclose($myfile);

        $content = file_get_contents($controller_path);
        $namespace = $this->argument('path') == 'null' ? null : '/'.$this->argument('path');
        $namespace = str_replace('/', '\\', $namespace);
        
        $prefix = strtolower(str_singular(snake_case($data['model'])));
        $prefixs = strtolower(str_plural(snake_case($data['model'])));
        $name = ucfirst(str_singular(camel_case($this->argument('name'))));

        $model = str_replace('/', '\\', ucfirst(str_singular($prefixs)));

        $controller = $name.'Controller';
        $code ='<?php

namespace App\Http\Controllers'.$namespace.';

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Alert;
use App\\'.''.$model.';

class '.$controller.' extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware(\'auth:admin\');
    }

    public function index()
    {
        return \Control::index(\''.$prefix.'\');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \Control::create(\''.$prefix.'\');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            \'translate\' => [
                \'title\' => \'required\',
                \'content\' => \'required\',
            ],
            \'stutes\' => \'required\',
            \'uri\' => \'required\',
        ]);

        //Request Photo Upload
        if(request()->hasFile(\'photo\')) {
           $data[\'photo\'] = Up()->upload([
                // \'new_name\'      =>  \'\',
                \'file\'          =>  \'photo\',
                \'path\'          =>  \''.$prefixs.'\',
                \'upload_type\'   =>  \'single\',
                \'delete_file\'   =>  \'\',
           ]); 
        }else{
          $data[\'photo\'] = null;
        }

        return \Control::store($request,\''.$prefix.'\',[
            \'translate\' => [\'title\',\'content\'],
            \'stutes\' => $request->stutes,
            \'uri\' => $request->uri,
            \'photo\' => $data[\'photo\'],
        ],aurl().\'/'.$prefixs.'\');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return \Control::show(\''.$prefix.'\',$id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return \Control::edit(\''.$prefix.'\',$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            \'translate\' => [
                \'title\' => \'required\',
                \'content\' => \'required\',
            ],
            \'stutes\' => \'required\',
            \'uri\' => \'required\',
        ]);

        //Request Photo Upload
        if(request()->hasFile(\'photo\')) {
           $data[\'photo\'] = Up()->upload([
                // \'new_name\'      =>  \'\',
                \'file\'          =>  \'photo\',
                \'path\'          =>  \''.$prefixs.'\',
                \'upload_type\'   =>  \'single\',
                \'delete_file\'   =>  '.ucfirst(str_singular($prefixs)).'::find($id)->photo,
           ]); 
        }else{
          $data[\'photo\'] = '.ucfirst(str_singular($prefixs)).'::find($id)->photo;
        }

        return \Control::update($request,$id,\''.$prefix.'\',[
            \'translate\' => [\'title\',\'content\'],
            \'stutes\' => $request->stutes,
            \'uri\' => $request->uri,
            \'photo\' => $data[\'photo\'],
        ],aurl().\'/'.$prefixs.'\');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null)
    {
        $'.$prefixs.' = '.ucfirst(str_singular($prefixs)).'::findOrFail($id);
        $'.$prefixs.'->delete();
        alert()->success(trans(\'lang.deleted\'), trans(\'lang.'.$prefix.'\'));
        return back();

        //return \Control::destroy($request,$id,\''.$prefix.'\');
    }

    public function order(Request $request)
    {
        return \Control::order($request->data,\''.$prefix.'\',0);
    }

    public function multi_delete(){
      if(is_array(request(\'item\'))){
        '.ucfirst(str_singular($prefixs)).'::destroy(request(\'item\'));
      }else{
        '.ucfirst(str_singular($prefixs)).'::find(request(\'item\'))->delete();
      }
      alert()->success(trans(\'lang.deleted\'), trans(\'lang.'.$prefix.'\'));
      return back();
    }

}
';

file_put_contents($controller_path,$code);
     }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = ucfirst(str_singular(camel_case($this->argument('name'))));
        $path = $this->argument('path') == 'null' ? null : $this->argument('path').'\\';
        $path = str_replace('/', '\\', $path);
        $namespace = $this->argument('path') == 'null' ? null : '\\'.$this->argument('path');
        $path_name = $this->argument('path') == 'null' ? null : $this->argument('path');
        $names = [
        'controller' => $path.$name.'Controller',
        'model' => $name,
        ];
        $this->createPath(app_path('Http/Controllers').'/'.$path);
        
        $path_url = str_replace('\\', '/', $names['controller']);
        $path_url = str_replace('/', '\\', app_path('Http/Controllers').'/'.$path_url.'.php');
            // $this->error(app_path('Http/Controllers').'/'.$path_url);
        if (file_exists($path_url)) 
        {
            $this->error('Controller [ '.$names['controller'].' ] Already Exist !');
        }else{

            $this->Controller($names);
            
            $this->info('Controller [ '.$names['controller'].' ] has been created successfuly');
        }
        
    }
}
