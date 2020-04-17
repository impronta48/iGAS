<?php
App::uses('AppHelper', 'View/Helper');

class OreHelper extends AppHelper {
    public function getLuogoDetail($r, $media = null)
    {
        $luogoDetail = $r['Ora']['luogoTrasferta'] ;
        if ($media == 'print')
        {
              return $luogoDetail;
        }

        if (!empty($r['Ora']['location_start']) || !empty( $r['Ora']['location_stop'] ) )
        {
            $luogoDetail .= ' <a data-toggle="tooltip" data-original-title="';

            if (!empty($r['Ora']['location_start']) )
            {
                $luogoDetail .=  'Inizio: ' . $r['Ora']['location_start'] ;
            }
            if (!empty($r['Ora']['location_stop']) )
            {
                $luogoDetail .= ' Fine: ' . $r['Ora']['location_stop'] ;
            }

            $luogoDetail .= '"href="https://www.google.com/maps/search/?api=1&query=' .
                                urlencode( $r['Ora']['location_start'] ) . '" ' .
                            'data-placement="top" target="map" class="btn bg-primary text-white btn-xs">Coord</a>';
        }

        return $luogoDetail;
    }

    public function getOraDetail($r)
    {
        $oraDetail = $r['Ora']['numOre'];
        $start = (!empty($r['Ora']['start'])) ? CakeTime::format($r['Ora']['start'],'%H:%m') : '--';
        $stop = (!empty($r['Ora']['stop'])) ? CakeTime::format($r['Ora']['stop'],'%H:%m') : '--';

        if (!empty($r['Ora']['start']) || !empty($r['Ora']['stop'])){
            $oraDetail .= "<small class=\"text-muted\"> ($start - $stop) </small>";
        }

        return $oraDetail;
    }

    public function getAttivitaDetail($r, $attivita_list)
    {
       return $attivita_list[$r['Ora']['eAttivita']]. '<small class="text-muted">/' . substr($r['Faseattivita']['Descrizione'],0,40) . '</small>';
    }

}