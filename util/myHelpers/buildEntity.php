<?php
    /**
     * Utilizar un arreglo de columnas para construir las variables protegidas
     * y los geters and setters
     */

    
    //  /** 
    //  * @ORM\Column(name="nombreUsuario")  
    //  */
    //  protected $fullName;
    
     function buildProtectedVar($varName)
     {
        echo('    /**'."\n\r"); 
        echo('     * @ORM\Column(name="'.$varName.'")'."\n\r");  
        echo('     */'."\n\r");
        echo('    protected $'.$varName.';'."\n\r");
        echo("\n\r"."\n\r");
     }
     
     function buildSetter($varName)
     {
        echo('    public function set'.$varName.'($'.$varName.')'."\n\r");  
        echo('    {'."\n\r"); 
        echo('        $this->'.$varName.' = $'.$varName.';'."\n\r"); 
        echo('    }'."\n\r");     
        echo(''."\n\r");
     }
     
     function buildGetter($varName)
     {
        echo('    public function get'.$varName.'()'."\n\r");  
        echo('    {'."\n\r"); 
        echo('        return $this->'.$varName.';'."\n\r"); 
        echo('    }'."\n\r");
        echo(''."\n\r");
     }    
     
     function process($varsNames)
     {
         echo(''."\n\r");
         foreach ($varsNames as $varName)
         {
             buildProtectedVar($varName);
         }
         
         foreach ($varsNames as $varName)
         {
             buildSetter($varName);
         }  
         
         foreach ($varsNames as $varName)
         {
             buildGetter($varName);
         }         
     }
     
     process([
        'IdUsuarioxPerfil', 
        'IdUsuario', 
        'IdPerfil', 
]);
     
     /*
      * USE MADYS_GIRO_TEST
      * SELECT "'" + COLUMN_NAME + "'," FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'ENG_Tramites_Tareas_Manifiesto';
      */
     
     //SELECT '''' + COLUMN_NAME + ''', ' FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'Generadores3erUsuario';
     
