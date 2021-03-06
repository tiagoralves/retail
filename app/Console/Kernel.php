<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        \App\Console\Commands\CreateActiveCasasBahia::class,
        \App\Console\Commands\CreateActivePontoFrio::class,
        \App\Console\Commands\CreateActiveExtra::class,
        \App\Console\Commands\CreateActiveMagazineLuiza::class,
        \App\Console\Commands\CreateActiveWalmartBrasil::class,
        \App\Console\Commands\CreateActiveRicardoEletro::class,
        \App\Console\Commands\CreateActiveCarrefour::class,
        \App\Console\Commands\CreateActiveFastShop::class,
        \App\Console\Commands\CreateActiveRipleyCl::class,
        \App\Console\Commands\CreateActiveParisCl::class,
        \App\Console\Commands\CreateActiveAbcdin::class,
        \App\Console\Commands\CreateActiveJumboColombia::class,
        \App\Console\Commands\CreateActiveAlkosto::class,
        \App\Console\Commands\CreateActiveExito::class,
        \App\Console\Commands\CreateActiveFalabellaCol::class,
        \App\Console\Commands\CreateActiveFalabellaPeru::class,
        \App\Console\Commands\CreateActiveRipleyPeru::class,
        \App\Console\Commands\CreateActiveGarbarino::class,
        \App\Console\Commands\CreateActiveFravega::class,
        \App\Console\Commands\CreateActiveCompumundo::class,
        \App\Console\Commands\CreateActiveRibeiro::class,
        \App\Console\Commands\CreateActivePanafoto::class,
        \App\Console\Commands\CreateActiveGolloTienda::class,
        \App\Console\Commands\CreateActiveHifi::class,
        \App\Console\Commands\CreateActiveComandato::class,
        \App\Console\Commands\CreateActiveTiendaMonge::class,
        \App\Console\Commands\CreateActiveWalmartMexico::class,
        \App\Console\Commands\CreateActiveClaroShop::class,
        \App\Console\Commands\CreateActiveLiverpool::class,
        \App\Console\Commands\CreateActiveBestBuy::class,
        \App\Console\Commands\CreateActiveAmazon::class,
        \App\Console\Commands\CreateActiveCostco::class,
        \App\Console\Commands\CreateActiveElpacioDeHierro::class,
        \App\Console\Commands\CreateActiveSears::class,
        \App\Console\Commands\CreateActiveElektra::class,
        \App\Console\Commands\CreateActiveSams::class,
        \App\Console\Commands\CreateActiveAmericanas::class,
        \App\Console\Commands\CreateActiveSubmarino::class, 

    ];


    protected function schedule(Schedule $schedule)
    {
        //casas Bahia
        $schedule->command('CreateActiveCasasBahia:insert')->dailyAt('3:00');
        $schedule->command('CreateActiveCasasBahia:insert')->dailyAt('11:00');
        $schedule->command('CreateActiveCasasBahia:insert')->dailyAt('19:00');
        //Ponto Frio
        $schedule->command('CreateActivePontoFrio:insert')->dailyAt('4:00');
        $schedule->command('CreateActivePontoFrio:insert')->dailyAt('12:00');
        $schedule->command('CreateActivePontoFrio:insert')->dailyAt('20:00');
        //Extra
        $schedule->command('CreateActiveExtra:insert')->dailyAt('5:00');
        $schedule->command('CreateActiveExtra:insert')->dailyAt('13:00');
        $schedule->command('CreateActiveExtra:insert')->dailyAt('21:00');
        //MagazineLuiza
        $schedule->command('CreateActiveMagazineLuiza:insert')->dailyAt('6:00');
        $schedule->command('CreateActiveMagazineLuiza:insert')->dailyAt('14:00');
        $schedule->command('CreateActiveMagazineLuiza:insert')->dailyAt('22:00');
        //WalmartBrasil
        $schedule->command('CreateActiveWalmartBrasil:insert')->dailyAt('7:00');
        $schedule->command('CreateActiveWalmartBrasil:insert')->dailyAt('15:00');
        $schedule->command('CreateActiveWalmartBrasil:insert')->dailyAt('23:00');
        //RicardoEletro
        $schedule->command('CreateActiveRicardoEletro:insert')->dailyAt('8:00');
        $schedule->command('CreateActiveRicardoEletro:insert')->dailyAt('16:00');
        $schedule->command('CreateActiveRicardoEletro:insert')->dailyAt('23:50');
        //Carrefour
        $schedule->command('CreateActiveCarrefour:insert')->dailyAt('8:30');
        $schedule->command('CreateActiveCarrefour:insert')->dailyAt('16:30');
        $schedule->command('CreateActiveCarrefour:insert')->dailyAt('22:30');
        //FastShop
        $schedule->command('CreateActiveFastShop:insert')->dailyAt('9:00');
        $schedule->command('CreateActiveFastShop:insert')->dailyAt('17:00');
        $schedule->command('CreateActiveFastShop:insert')->dailyAt('21:00');
        //FalabellaChile
        $schedule->command('CreateActiveFalabellaChile:insert')->dailyAt('3:05');
        $schedule->command('CreateActiveFalabellaChile:insert')->dailyAt('11:05');
        $schedule->command('CreateActiveFalabellaChile:insert')->dailyAt('19:05');
        //ipleyCl
        $schedule->command('CreateActiveRipleyCl:insert')->dailyAt('03:25');
        $schedule->command('CreateActiveRipleyCl:insert')->dailyAt('12:25');
        $schedule->command('CreateActiveRipleyCl:insert')->dailyAt('20:25');
        //
        $schedule->command('CreateActiveParisCl:insert')->dailyAt('5:05');
        $schedule->command('CreateActiveParisCl:insert')->dailyAt('13:05');
        $schedule->command('CreateActiveParisCl:insert')->dailyAt('21:05');
        //
        $schedule->command('CreateActiveAbcdin:insert')->dailyAt('6:05');
        $schedule->command('CreateActiveAbcdin:insert')->dailyAt('14:05');
        $schedule->command('CreateActiveAbcdin:insert')->dailyAt('22:05');
        //Jumbo
        $schedule->command('CreateActiveJumboColombia:insert')->dailyAt('7:10');
        $schedule->command('CreateActiveJumboColombia:insert')->dailyAt('14:10');
        $schedule->command('CreateActiveJumboColombia:insert')->dailyAt('22:10');
        //Alkosto
        $schedule->command('CreateActiveAlkosto:insert')->dailyAt('8:05');
        $schedule->command('CreateActiveAlkosto:insert')->dailyAt('16:05');
        $schedule->command('CreateActiveAlkosto:insert')->dailyAt('23:05');
        //Exito
        $schedule->command('CreateActiveExito:insert')->dailyAt('9:05');
        $schedule->command('CreateActiveExito:insert')->dailyAt('17:05');
        $schedule->command('CreateActiveExito:insert')->dailyAt('22:15');
        //FalabellaCol
        $schedule->command('CreateActiveFalabellaCol:insert')->dailyAt('9:08');
        $schedule->command('CreateActiveFalabellaCol:insert')->dailyAt('17:08');
        $schedule->command('CreateActiveFalabellaCol:insert')->dailyAt('22:08');
        //
        $schedule->command('CreateActiveFalabellaPeru:insert')->dailyAt('3:08');
        $schedule->command('CreateActiveFalabellaPeru:insert')->dailyAt('11:08');
        $schedule->command('CreateActiveFalabellaPeru:insert')->dailyAt('19:08');
        //RipleyPeru
        $schedule->command('CreateActiveRipleyPeru:insert')->dailyAt('4:08');
        $schedule->command('CreateActiveRipleyPeru:insert')->dailyAt('12:08');
        $schedule->command('CreateActiveRipleyPeru:insert')->dailyAt('20:08');
        //
        $schedule->command('CreateActiveGarbarino:insert')->dailyAt('3:30');
        $schedule->command('CreateActiveGarbarino:insert')->dailyAt('11:30');
        $schedule->command('CreateActiveGarbarino:insert')->dailyAt('19:30');
        //
        $schedule->command('CreateActiveFravega:insert')->dailyAt('4:30');
        $schedule->command('CreateActiveFravega:insert')->dailyAt('12:30');
        $schedule->command('CreateActiveFravega:insert')->dailyAt('20:30');
        //
        $schedule->command('CreateActiveCompumundo:insert')->dailyAt('5:30');
        $schedule->command('CreateActiveCompumundo:insert')->dailyAt('13:30');
        $schedule->command('CreateActiveCompumundo:insert')->dailyAt('21:30');
        //
        $schedule->command('CreateActiveRibeiro:insert')->dailyAt('6:30');
        $schedule->command('CreateActiveRibeiro:insert')->dailyAt('14:30');
        $schedule->command('CreateActiveRibeiro:insert')->dailyAt('22:30');
        //
        $schedule->command('CreateActivePanafoto:insert')->dailyAt('3:35');
        $schedule->command('CreateActivePanafoto:insert')->dailyAt('11:35');
        $schedule->command('CreateActivePanafoto:insert')->dailyAt('19:35');
        //
        $schedule->command('CreateActiveGolloTienda:insert')->dailyAt('4:35');
        $schedule->command('CreateActiveGolloTienda:insert')->dailyAt('12:35');
        $schedule->command('CreateActiveGolloTienda:insert')->dailyAt('20:35');
        //
        $schedule->command('CreateActiveHifi:insert')->dailyAt('5:35');
        $schedule->command('CreateActiveHifi:insert')->dailyAt('13:35');
        $schedule->command('CreateActiveHifi:insert')->dailyAt('19:15');
        //
        $schedule->command('CreateActiveComandato:insert')->dailyAt('7:30');
        $schedule->command('CreateActiveComandato:insert')->dailyAt('15:30');
        $schedule->command('CreateActiveComandato:insert')->dailyAt('23:30');
        //
        $schedule->command('CreateActiveTiendaMonge:insert')->dailyAt('6:35');
        $schedule->command('CreateActiveTiendaMonge:insert')->dailyAt('14:35');
        $schedule->command('CreateActiveTiendaMonge:insert')->dailyAt('22:35');
        //
        $schedule->command('CreateActiveWalmartMexico:insert')->dailyAt('3:38');
        $schedule->command('CreateActiveWalmartMexico:insert')->dailyAt('11:38');
        $schedule->command('CreateActiveWalmartMexico:insert')->dailyAt('19:38');
        //
        $schedule->command('CreateActiveClaroShop:insert')->dailyAt('4:38');
        $schedule->command('CreateActiveClaroShop:insert')->dailyAt('12:38');
        $schedule->command('CreateActiveClaroShop:insert')->dailyAt('20:38');
        //
        $schedule->command('CreateActiveLiverpool:insert')->dailyAt('6:37');
        $schedule->command('CreateActiveLiverpool:insert')->dailyAt('14:37');
        $schedule->command('CreateActiveLiverpool:insert')->dailyAt('22:37');
        //
        $schedule->command('CreateActiveBestBuy:insert')->dailyAt('7:35');
        $schedule->command('CreateActiveBestBuy:insert')->dailyAt('15:35');
        $schedule->command('CreateActiveBestBuy:insert')->dailyAt('23:35');
        //
        $schedule->command('CreateActiveAmazon:insert')->dailyAt('8:10');
        $schedule->command('CreateActiveAmazon:insert')->dailyAt('16:10');
        $schedule->command('CreateActiveAmazon:insert')->dailyAt('20:17');
        //
        $schedule->command('CreateActiveCostco:insert')->dailyAt('8:35');
        $schedule->command('CreateActiveCostco:insert')->dailyAt('16:35');
        $schedule->command('CreateActiveCostco:insert')->dailyAt('19:40');
        //
        $schedule->command('CreateActiveElpacioDeHierro:insert')->dailyAt('10:10');
        $schedule->command('CreateActiveElpacioDeHierro:insert')->dailyAt('14:12');
        $schedule->command('CreateActiveElpacioDeHierro:insert')->dailyAt('21:10');
        //
        $schedule->command('CreateActiveSears:insert')->dailyAt('10:15');
        $schedule->command('CreateActiveSears:insert')->dailyAt('13:28');
        $schedule->command('CreateActiveSears:insert')->dailyAt('20:50');
        //
        $schedule->command('CreateActiveElektra:insert')->dailyAt('5:40');
        $schedule->command('CreateActiveElektra:insert')->dailyAt('17:40');
        $schedule->command('CreateActiveElektra:insert')->dailyAt('20:40');
        //
        $schedule->command('CreateActiveSams:insert')->dailyAt('10:30');
        $schedule->command('CreateActiveSams:insert')->dailyAt('18:30');
        $schedule->command('CreateActiveSams:insert')->dailyAt('22:30');
        //
        $schedule->command('CreateActiveAmericanas:insert')->dailyAt('10:00');
        $schedule->command('CreateActiveAmericanas:insert')->dailyAt('18:00');
        $schedule->command('CreateActiveAmericanas:insert')->dailyAt('23:40');
        //
        $schedule->command('CreateActiveSubmarino:insert')->dailyAt('10:30');
        $schedule->command('CreateActiveSubmarino:insert')->dailyAt('15:50');
        $schedule->command('CreateActiveSubmarino:insert')->dailyAt('21:50');



    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
