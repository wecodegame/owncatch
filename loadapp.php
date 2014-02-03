owncatch
========
function loadApp($app, $global_instance = false) {

   $app_name = ($app_name = strrchr($app, "/")) ? substr($app_name, 1) : $app;
   $directory = ($app_name != $app) ? substr($app, 0, strlen($app_name)*-1) : "";

   if(file_exists(APPS . uncamelize($directory) . uncamelize($app_name) . ".php")) {

      require_once(APPS . uncamelize($directory) . uncamelize($app_name) . ".php");

      # Aufgerufene Klasse laden
      if($global_instance !== false) {

         $global_app_name = "app_" . strtolower($app_name);

         if($GLOBALS["reg"]->$global_app_name) return $GLOBALS["reg"]->$global_app_name;
      }

      $class = "APP_" . ucfirst($app_name);
      $return = new $class($GLOBALS["reg"]);

      if($global_instance !== false) $GLOBALS["reg"]->$global_app_name = $return;

      return $return;

   } else {

      die("Unbekannte Applikation {$app_name}");
   }
}
