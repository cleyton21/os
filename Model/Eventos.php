<?php

namespace Model;

include_once "DB.php";

class Eventos extends DB
{
    public function __construct()
    {
        $query_events = "SELECT incidentes.incidente, incidentes.cor, chamados.created_at, chamados.updated_at FROM `chamados`
        INNER JOIN incidentes 
        ON incidentes.id_incidente = chamados.id_incidente";
        $resultado_events = self::conn()->prepare($query_events);
        $resultado_events->execute();

        $eventos = [];

        while($row_events = $resultado_events->fetch(\PDO::FETCH_ASSOC)) {
            $incidente = $row_events['incidente'];
            $color = $row_events['cor'];
            $start = $row_events['created_at'];
            $end = $row_events['updated_at'];

            $eventos[] = [
                'title' => $incidente,
                'color' => $color,
                'start' => $start,
                'end' => $end
            ];
        }

        echo json_encode($eventos);
    }
}