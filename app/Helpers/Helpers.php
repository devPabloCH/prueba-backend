<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Auth;

class Helpers
{
    public static function generarCodigo($length = 8, $only_numbers = 0)
    {
        $possibleChars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        if ($only_numbers == 1) {
            $possibleChars = "0123456789";
        }
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $rand = rand(0, strlen($possibleChars) - 1);
            $password .= substr($possibleChars, $rand, 1);
        }

        return $password;
    }

    public static function FormatDate($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::parse($fecha);
            $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha, env('APP_TIMEZONE', 'Europe/Madrid'));
        }
        return $fecha;
    }

    public static function Age($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::parse($fecha);
            $fecha = $fecha->age;
        }
        return $fecha;
    }

    public static function AgeYear($fecha)
    {
        $interval = date_diff(date_create(), date_create($fecha . ' ' . date('H:m:s')));
        return $interval->format("%Y");
    }
    public static function AgeMonth($fecha)
    {
        $interval = date_diff(date_create(), date_create($fecha . ' ' . date('H:m:s')));
        return $interval->format("%M");
    }
    public static function AgeDays($fecha)
    {
        $interval = date_diff(date_create(), date_create($fecha . ' ' . date('H:m:s')));
        return $interval->format("%d");
    }

    public static function FormatDate_DMY_YMD($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::createFromFormat('d/m/Y', $fecha)->format('Y-m-d');
        }
        return $fecha;
    }

    public static function FormatDate_YMD_DMY($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::createFromFormat('Y-m-d', $fecha)->format('d/m/Y');
        }
        return $fecha;
    }

    public static function FormatDate_YMD_Text($fecha)
    {
        $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha)->format('Y-m-d H:i:s');
        return $fecha;
    }

    public static function FormatDate_YMD_DMY_Completa($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha)->format('d/m/Y g:i A');
        }
        return $fecha;
    }

    public static function FormatDate_YMD_Completa_Hour12($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha)->format('g:i A');
        }
        return $fecha;
    }

    public static function FormatDate_YMD_Completa_Hour24($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha)->format('H:i:s');
        }
        return $fecha;
    }

    public static function FormatHour_24_12($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::createFromFormat('H:i:s', $fecha)->format('g:i A');
        }
        return $fecha;
    }

    public static function FormatHour_12_24($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::createFromFormat('g:i A', $fecha)->format('H:i:s');
        }
        return $fecha;
    }

    public static function FormatDate_DMY_DMYHIS($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::createFromFormat('d/m/Y g:i A', $fecha)->format('d/m/Y H:i:s');
        }
        return $fecha;
    }

    public static function FormatDate_DMY_YMD_Completa($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::createFromFormat('d/m/Y g:i A', $fecha)->format('Y-m-d H:i:s');
        }
        return $fecha;
    }

    public static function FormatUnix_DMY_CompletaDMY($unix)
    {
        return Carbon::createFromTimestamp($unix)->format('d/m/Y g:i A');
    }

    public static function FormatUnix_DMY_CompletaYMD($unix)
    {
        return Carbon::createFromTimestamp($unix)->format('Y-m-d H:i:s');
    }

    public static function FormatDate_YMD_DMY_Unix($fecha)
    {
        $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha)->format('U');
        return $fecha;
    }

    public static function FormatDate_Unix_Time($unix)
    {
        $fecha = Carbon::createFromTimestamp($unix)->toDateTimeString();
        return $fecha;
    }

    public static function FormatISO8601_DMY_Completa_WithoutTimezone($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::parse($fecha);
            $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha, 'UTC');
            $fecha = self::FormatDate_YMD_DMY_Completa($fecha);
        }
        return $fecha;
    }

    public static function FormatISO8601_DMY_Completa_Timezone($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::parse($fecha);
            $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha, 'UTC');
            $fecha->setTimezone(env('APP_TIMEZONE', 'Europe/Madrid'));
            $fecha = self::FormatDate_YMD_DMY_Completa($fecha);
        }
        return $fecha;
    }

    public static function FormatISO8601_DMY_Completa($fecha)
    {
        if ($fecha != "") {
            $fecha = Carbon::parse($fecha);
            $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha, 'UTC');
            $fecha->setTimezone(Auth::user()->timezone);
            $fecha = self::FormatDate_YMD_DMY_Completa($fecha);
        }
        return $fecha;
    }

    public static function SubstractDate($fecha, $cant, $tipo)
    {
        $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha);
        $tipo = 'sub' . $tipo;
        $fecha->$tipo($cant);
        return $fecha;
    }

    public static  function fecha()
    {
        $fecha = date('Y-m-d H:i:s');
        return $fecha;
    }

    public static  function fechaCarbon()
    {
        $fecha = Carbon::now()->format('Y-m-d H:i:s');
        return $fecha;
    }

    public static function fechaLess()
    {
        $fecha = date('Y-m-d--H-i-s');
        return $fecha;
    }

    public static function fecha_guion()
    {
        $fecha_guion = date('Y-m-d');
        return $fecha_guion;
    }

    public static function solo_hora()
    {
        $fecha_guion = date('H:i:s');
        return $fecha_guion;
    }

    public static function fecha_barra()
    {
        $fecha_barra = date('d/m/Y');
        return $fecha_barra;
    }

    public static function fecha_hoy()
    {
        $dt = Carbon::now();
        return $dt->toDateString();
    }


    public static function hora()
    {
        $dt = Carbon::now();
        return $dt->toTimeString();
    }

    public static function dia()
    {
        $dia = date('d');
        return $dia;
    }

    public static function mes()
    {
        $mes = date('m');
        return $mes;
    }

    public static function anio()
    {
        $anio = date('Y');
        return $anio;
    }

    public static function PrimerDiaSemana()
    {
        $year = date('Y');
        $month = date('m');
        $day = date('d');
        # Obtenemos el numero de la semana
        $semana = date("W", mktime(0, 0, 0, $month, $day, $year));
        # Obtenemos el día de la semana de la fecha dada
        $diaSemana = date("w", mktime(0, 0, 0, $month, $day, $year));
        # el 0 equivale al domingo...
        if ($diaSemana == 0)
            $diaSemana = 7;
        # A la fecha recibida, le restamos el dia de la semana y obtendremos el lunes
        $primerDia = date("Y-m-d", mktime(0, 0, 0, $month, $day - $diaSemana + 1, $year));

        return $primerDia;
    }

    public static function UltimoDiaSemana()
    {
        $year = date('Y');
        $month = date('m');
        $day = date('d');

        # Obtenemos el numero de la semana
        $semana = date("W", mktime(0, 0, 0, $month, $day, $year));

        # Obtenemos el día de la semana de la fecha dada
        $diaSemana = date("w", mktime(0, 0, 0, $month, $day, $year));

        # el 0 equivale al domingo...
        if ($diaSemana == 0)
            $diaSemana = 7;
        # A la fecha recibida, le sumamos el dia de la semana menos siete y obtendremos el domingo
        $ultimoDia = date("Y-m-d", mktime(0, 0, 0, $month, $day + (7 - $diaSemana), $year));

        return $ultimoDia;
    }

    public static function PrimerDiaMes()
    {
        $month = date('m');
        $year = date('Y');
        return date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
    }

    public static function UltimoDiasMes()
    {
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));

        return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
    }

    public static function FechaHoy()
    {
        return date('Y-m-d');
    }

    public static function FechaHoraActual()
    {
        return date('Y-m-d H:i:s');
    }

    public static function FormatDate_Text($fecha)
    {
        $fecha = explode('-', $fecha);
        $dia = $fecha[2];
        $mes = (int) $fecha[1];
        $anio = $fecha[0];

        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
        $meses = array(
            __('January'), __('February'), __('March'), __('April'), __('May'), __('June'),
            __('July'), __('August'), __('September'), __('October'), __('November'), __('December')
        );
        return $dia . ' de  ' . $meses[$mes - 1] . ' de ' . $anio;

        //echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        //Salida: Viernes 24 de Febrero del 2012
    }

    public static function FormatDate_Text_($fecha)
    {
        setlocale(LC_TIME, __('English'));
        $dt = Carbon::createFromFormat('Y-m-d', $fecha);
        Carbon::setUtf8(true);
        return $dt->formatLocalized('%d %B');;
    }


    public static function msuccess($mensaje, $class = "")
    {
        return $activo = '<span class="badge badge-success ' . $class . '">' . $mensaje . '</span>';
    }

    public static function minfo($mensaje, $class = "")
    {
        return $activo = '<span class="badge badge-info ' . $class . '">' . $mensaje . '</span>';
    }

    public static function mprimary($mensaje, $class = "")
    {
        return $activo = '<span class="badge badge-primary ' . $class . '">' . $mensaje . '</span>';
    }

    public static function mdanger($mensaje, $class = "")
    {
        return $inactivo = '<span class="badge badge-danger ' . $class . '">' . $mensaje . '</span>';
    }

    public static function mwarning($mensaje, $class = "")
    {
        return $inactivo = '<span class="badge badge-warning ' . $class . '">' . $mensaje . '</span>';
    }

    public static function minverse($mensaje, $class = "")
    {
        return $inactivo = '<span class="badge badge-inverse ' . $class . '">' . $mensaje . '</span>';
    }

    public static function nombre_mes($mes)
    {
        if ($mes == "01" || $mes == '1') $mes = "Enero";
        if ($mes == "02" || $mes == '2') $mes = "Febrero";
        if ($mes == "03" || $mes == '3') $mes = "Marzo";
        if ($mes == "04" || $mes == '4') $mes = "Abril";
        if ($mes == "05" || $mes == '5') $mes = "Mayo";
        if ($mes == "06" || $mes == '6') $mes = "Junio";
        if ($mes == "07" || $mes == '7') $mes = "Julio";
        if ($mes == "08" || $mes == '8') $mes = "Agosto";
        if ($mes == "09" || $mes == '9') $mes = "Setiembre";
        if ($mes == "10" || $mes == '10') $mes = "Octubre";
        if ($mes == "11" || $mes == '11') $mes = "Noviembre";
        if ($mes == "12" || $mes == '12') $mes = "Diciembre";
        return $mes;
    }

    public static function nombre_dia($dia)
    {
        if ($dia == "00" || $dia == '0') $dia = "Domingo";
        if ($dia == "01" || $dia == '1') $dia = "Lunes";
        if ($dia == "02" || $dia == '2') $dia = "Martes";
        if ($dia == "03" || $dia == '3') $dia = "Miercoles";
        if ($dia == "04" || $dia == '4') $dia = "Jueves";
        if ($dia == "05" || $dia == '5') $dia = "Viernes";
        if ($dia == "06" || $dia == '6') $dia = "Sabado";
        return $dia;
    }

    public static function nombre_dia_abreviado($dia)
    {
        if ($dia == "00" || $dia == '0') $dia = "D";
        if ($dia == "01" || $dia == '1') $dia = "L";
        if ($dia == "02" || $dia == '2') $dia = "M";
        if ($dia == "03" || $dia == '3') $dia = "M";
        if ($dia == "04" || $dia == '4') $dia = "J";
        if ($dia == "05" || $dia == '5') $dia = "V";
        if ($dia == "06" || $dia == '6') $dia = "S";
        return $dia;
    }

    public static function saber_dia_numero($fecha)
    {
        $fecha = date('w', strtotime($fecha));
        return $fecha;
    }

    public static function saber_dia($fecha)
    {
        $fecha = Helpers::nombre_dia_abreviado(date('w', strtotime($fecha)));
        return $fecha;
    }
    public static function saber_dia_completo($fecha)
    {
        $fecha = Helpers::nombre_dia(date('w', strtotime($fecha)));
        return $fecha;
    }

    public static function checkPermission($permissions)
    {
        if (Auth::user()) {
            $userAccess = Helpers::getMyPermission(Auth::user()->type_user);
            foreach ($permissions as $key => $value) {
                if ($value == $userAccess) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function getMyPermission($id)
    {
        switch ($id) {
            case 0:
                return __('SuperAdmin');
                break;
            case 1:
                return __('Establecimiento');
                break;
            case 2:
                return __('Cliente');
                break;
            case 3:
                return __('Rider');
                break;
            case 4:
                return __('Admin');
                break;
            default:
                return '';
                break;
        }
    }

    public static function sanear_nombre($string)
    {

        $string = trim($string);

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );

        $string = str_replace(
            array(" "),
            '-',
            $string
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array(
                "º", "~", "`",
                "#", "@", "|", "!",
                "·", "$", "%", "&", "/",
                "(", ")", "?", "'", "¡",
                "¿", "[", "^", "<code>", "]",
                "+", "}", "{", "¨", "´",
                ">", "< ", ";", ",", ":",
                "."
            ),
            '',
            $string
        );


        return $string;
    }

    public static function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public static function TimeZoneList()
    {
        $regions = array(
            DateTimeZone::AFRICA,
            DateTimeZone::AMERICA,
            DateTimeZone::ANTARCTICA,
            DateTimeZone::ASIA,
            DateTimeZone::ATLANTIC,
            DateTimeZone::AUSTRALIA,
            DateTimeZone::EUROPE,
            DateTimeZone::INDIAN,
            DateTimeZone::PACIFIC,
        );

        $timezones = array();
        foreach ($regions as $region) {
            $timezones = array_merge($timezones, DateTimeZone::listIdentifiers($region));
        }

        $timezone_offsets = array();
        foreach ($timezones as $timezone) {
            $tz = new DateTimeZone($timezone);
            $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
        }

        // sort timezone by offset
        asort($timezone_offsets);

        $timezone_list = array();
        foreach ($timezone_offsets as $timezone => $offset) {
            $offset_prefix = $offset < 0 ? '-' : '+';
            $offset_formatted = gmdate('H:i', abs($offset));

            $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

            $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
        }
        return $timezone_list;
    }

    public static function array_flatten($array)
    {
        if (!is_array($array)) {
            return FALSE;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, Helpers::array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    public static function miliseconds_to_hms($input)
    {
        $uSec = $input % 1000;
        $input = floor($input / 1000);

        $seconds = $input % 60;
        $input = floor($input / 60);

        $minutes = $input % 60;
        $input = floor($input / 60);

        $hour = $input;

        return sprintf('%02dh %02dm %02ds', $hour, $minutes, $seconds);
    }

    public static  function ZerosCustom($number, $length)
    {
        return str_pad($number, $length, '0', STR_PAD_LEFT);
    }

    public static  function Zeros($number)
    {
        return str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public static  function DNI($number)
    {
        return str_pad($number, 8, '0', STR_PAD_LEFT);
    }

    public static function TipoDocumento($type)
    {
        if ($type == 1) {
            $type = "DNI";
        } else if ($type == 2) {
            $type = "NIE";
        } else if ($type == 3) {
            $type = "OTRO";
        }
        // else if($type==4){
        //   $type = "PASAPORTE ESPAÑOL";
        // }
        // else if($type==5){
        //   $type = "PASAPORTE EXTRANJERO";
        // }
        // else if($type==6){
        //   $type = "S/DOCUMENTO";
        // }
        return $type;
    }

    public static function ip()
    {
        $ip = file_get_contents("http://ipinfo.io/ip");
        if (!$ip) {
            $ip = Helpers::getUserIpAddr();
        }
        return $ip;
    }

    public static function ipLocalization()
    {
        $location = file_get_contents("http://ipinfo.io/loc");
        if (!$location) {
            $ip = Helpers::getUserIpAddr();
            $data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip));
            if ($data != null) {
                $location = $data['geoplugin_latitude'] . ',' . $data['geoplugin_longitude'];
            }
        }
        return $location;
    }

    public static function isPrivateIP($value)
    {
        if ($value == '127.0.0.1')
            return true;

        if (strpos($value, '192.168.') === 0)
            return true;

        if (strpos($value, '10.') === 0)
            return true;

        if (strpos($value, '::1') === 0)
            return true;

        return false;
    }

    public static function getUserIpAddr()
    {
        $ipaddress = '';
        if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else
            $ipaddress = '';

        return $ipaddress;
    }

    public static function grades_cardinal($grades)
    {
        switch ($grades) {
            case ($grades >= 0 && $grades < 22.5) || ($grades == 360):
                return 'N';
                break;
            case ($grades >= 22.5 && $grades < 45):
                return 'NNE';
                break;
            case ($grades >= 45 && $grades < 67.5):
                return 'NE';
                break;
            case ($grades >= 67.5 && $grades < 90):
                return 'ENE';
                break;
            case ($grades >= 90 && $grades < 112.5):
                return 'E';
                break;
            case ($grades >= 112.5 && $grades < 135):
                return 'ESE';
                break;
            case ($grades >= 135 && $grades < 157.5):
                return 'SE';
                break;
            case ($grades >= 157.5 && $grades < 180):
                return 'SSE';
                break;
            case ($grades >= 180 && $grades < 202.5):
                return 'S';
                break;
            case ($grades >= 202.5 && $grades < 225):
                return 'SSO';
                break;
            case ($grades >= 225 && $grades < 247.5):
                return 'SO';
                break;
            case ($grades >= 247.5 && $grades < 270):
                return 'OSO';
                break;
            case ($grades >= 270 && $grades < 292.5):
                return 'O';
                break;
            case ($grades >= 292.5 && $grades < 315):
                return 'ONO';
                break;
            case ($grades >= 315 && $grades < 337.5):
                return 'NO';
                break;
            case ($grades >= 337.5 && $grades < 360):
                return 'NNO';
                break;
        }
    }

    public static function grades_cardinal4($grades)
    {
        switch ($grades) {
            case ($grades == 0) || ($grades > 0 && $grades < 45) || ($grades == 360):
                return 'N';
                break;
            case ($grades >= 45 && $grades < 90):
                return 'N';
                break;
            case ($grades >= 90 && $grades < 135):
                return 'E';
                break;
            case ($grades >= 135 && $grades < 180):
                return 'S';
                break;
            case ($grades >= 180 && $grades < 225):
                return 'S';
                break;
            case ($grades >= 225 && $grades < 270):
                return 'S';
                break;
            case ($grades >= 270 && $grades < 315):
                return 'O';
                break;
            case ($grades >= 315 && $grades < 360):
                return 'O';
                break;
        }
    }

    public static function grades_cardinal8($grades)
    {
        switch ($grades) {
            case ($grades == 0) || ($grades > 0 && $grades < 45) || ($grades == 360):
                return 'N';
                break;
            case ($grades >= 45 && $grades < 90):
                return 'NE';
                break;
            case ($grades >= 90 && $grades < 135):
                return 'E';
                break;
            case ($grades >= 135 && $grades < 180):
                return 'SE';
                break;
            case ($grades >= 180 && $grades < 225):
                return 'S';
                break;
            case ($grades >= 225 && $grades < 270):
                return 'SO';
                break;
            case ($grades >= 270 && $grades < 315):
                return 'O';
                break;
            case ($grades >= 315 && $grades < 360):
                return 'NO';
                break;
        }
    }

    public static function roundCoordinate($value, $decimals = 5)
    {
        return round($value, $decimals);
    }

    public static function roundSpeed($value)
    {
        return ceil($value);
    }

    public static function sendFCM($title, $body, $sound = false, $target)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $notification = array(
            "title" => $title,
            'body' => $body,
        );
        if ($sound == true) {
            $notification['sound'] = 'sound.mp3';
        } else {
            $notification['sound'] = 'default';
        }

        $fields = array(
            'priority' => 'high',
            'data' => array(
                "message" => $body
            ),
            'notification' => $notification
        );
        if (is_array($target)) {
            $fields['registration_ids'] = $target;
        } else {
            $fields['to'] = $target;
        }
        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . env('FCM_SERVER_KEY'),
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public static function sumTimes($times)
    {
        $minutes = 0;
        foreach ($times as $time) {
            list($hour, $minute) = explode(':', $time);
            $minutes += $hour * 60;
            $minutes += $minute;
        }

        $hours = floor($minutes / 60);
        $minutes -= $hours * 60;
        return sprintf('%02d:%02d', $hours, $minutes);
    }
    public static function HTMLToRGB($htmlCode)
    {
        if ($htmlCode[0] == '#')
            $htmlCode = substr($htmlCode, 1);

        if (strlen($htmlCode) == 3) {
            $htmlCode = $htmlCode[0] . $htmlCode[0] . $htmlCode[1] . $htmlCode[1] . $htmlCode[2] . $htmlCode[2];
        }

        $r = hexdec($htmlCode[0] . $htmlCode[1]);
        $g = hexdec($htmlCode[2] . $htmlCode[3]);
        $b = hexdec($htmlCode[4] . $htmlCode[5]);

        return $b + ($g << 0x8) + ($r << 0x10);
    }

    public static function RGBToHSL($RGB)
    {
        $r = 0xFF & ($RGB >> 0x10);
        $g = 0xFF & ($RGB >> 0x8);
        $b = 0xFF & $RGB;

        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;

        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);

        $l = ($maxC + $minC) / 2.0;

        if ($maxC == $minC) {
            $s = 0;
            $h = 0;
        } else {
            if ($l < .5) {
                $s = ($maxC - $minC) / ($maxC + $minC);
            } else {
                $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
            }
            if ($r == $maxC)
                $h = ($g - $b) / ($maxC - $minC);
            if ($g == $maxC)
                $h = 2.0 + ($b - $r) / ($maxC - $minC);
            if ($b == $maxC)
                $h = 4.0 + ($r - $g) / ($maxC - $minC);

            $h = $h / 6.0;
        }

        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);

        return (object) array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }
}
