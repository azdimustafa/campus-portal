<?php

namespace Modules\Site\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Modules\Site\Entities\Department;
use Modules\Site\Entities\Organization;
use Modules\Site\Entities\Ptj;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GeneratePtjCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:organization';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate PTJ from API Services';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $token = config('app.um_api_token');
        $ptjUrl = config('app.um_api_url'). '/v1/hris/lookup/ptj?orderBy=PTG_KTRGN_PTJ&sort=ASC';
        $deptUrl = config('app.um_api_url'). '/v1/hris/lookup/jbt?orderBy=JBT_KTRGN_JABATAN&sort=ASC';
        
        $responsePtj = Http::withToken($token)->get($ptjUrl);  
        $responseDept = Http::withToken($token)->get($deptUrl);   
        
        if ($responsePtj->status() == 200 && $responseDept->status() == 200) {
            $this->info('================================================');
            $this->info('Call API successfully');
            $this->info('================================================');
            
            $bodyPtj = json_decode($responsePtj->body());
            $bodyDept = json_decode($responseDept->body());

            $this->output->progressStart($bodyPtj->totalResults);

            foreach ($bodyPtj->body as $ptj) {
                $kodPtj = $ptj->PTG_KOD_PTJ;
            
                // save ptj
                $savePtj = Ptj::create([
                    'code' => $ptj->PTG_KOD_PTJ,
                    'short_name' => $ptj->PTG_KTRGN_SINGKAT , 
                    'name' => $ptj->PTG_KTRGN_BI, 
                    'name_my' => $ptj->PTG_KTRGN_PTJ,
                    'email' => $ptj->PTG_EMAIL,
                    'is_academic' => $ptj->PTG_STATUS == 'A' ? 1 : 0,
                    'active' => $ptj->PTG_AKTIF == 'Y' ? 1 : 0,
                ]);

                // save department
                foreach ($bodyDept->body as $dept) {
                    if (isset($dept->JBT_KOD_PTJ) && $dept->JBT_KOD_PTJ == $kodPtj) {
                        Department::create([
                            'code' => $dept->JBT_KOD_JABATAN,
                            'short_name' => $dept->JBT_KTRGN_SINGKAT,
                            'name' => $dept->JBT_DESC_JABATAN,
                            'name_my' => $dept->JBT_KTRGN_JABATAN,
                            'ptj_id' => $savePtj->id, 
                            'is_academic' => $dept->JBT_AKADEMIK == "Y" ? 1 : 0, 
                            'active' => $dept->JBT_AKTIF == 'Y' ? 1 : 0,
                        ]); 
                    }
                }

                $this->output->progressAdvance();
            }
            $this->output->progressFinish();
        }
        else {
            $this->error('Failed to call API');
        }

        // if ($response->status() == 200 && $responseDept->status() == 200) {
        //     $body = json_decode($response->body());
        //     $bodyDept = json_decode($responseDept->body());
        
        //     foreach ($body->data as $ptj) {
    
        //         $savedPtj = Ptj::create([
        //             'code' => $ptj->PTG_KOD_PTJ,
        //             'short_name' => $ptj->PTG_KTRGN_SINGKAT , 
        //             'name' => $ptj->PTG_KTRGN_BI, 
        //             'name_my' => $ptj->PTG_KTRGN_PTJ,
        //         ]);

        //         $ptjDepts = [];
        //         $noDept = 1;
        //         foreach ($bodyDept->data as $dept) {
        //             if ($dept->JBT_KOD_PTJ == $ptj->PTG_KOD_PTJ) {
        //                 $ptjDepts[] = $dept;

        //                 Department::create([
        //                     'code' => $dept->JBT_KOD_JABATAN,
        //                     'short_name' => $dept->JBT_KTRGN_SINGKAT,
        //                     'name' => $dept->JBT_DESC_JABATAN,
        //                     'name_my' => $dept->JBT_KTRGN_JABATAN,
        //                     'ptj_id' => $savedPtj->id, 
        //                 ]);                            

        //                 $noDept++;
        //             }
        //         }
        //     }
        // }
        // $this->info('PTj/Departments successfully generated!!');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
