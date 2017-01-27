<p>
    Con la seguente mail ti confermiamo che hai prenotato {{ ($count == 1) ? ('1 posto') : ($count . ' posti') }} per il concerto che si tiene {{ $slot->printableDate() }} alle ore {{ $slot->printableHour() }}.<br/>
    Ti aspettiamo in {{ $slot->location->address }} quindici minuti  prima dell'inizio del concerto.
</p>

<p>
    Se cambi idea ti preghiamo di cancellare la tua prenotazione per lasciare il posto ad altre persone. Grazie!
</p>

<p>
    Per qualsiasi ulteriore informazione scrivi a adottaunpianista@gmail.com
</p>
