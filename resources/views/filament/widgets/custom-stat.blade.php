<div 
    class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 border {{ 
        $color == 'red' ? 'border-red-400' : '' }} {{ 
        $color == 'blue' ? 'border-blue-400' : '' }} {{ 
        $color == 'green' ? 'border-green-400' : '' }} {{ 
        $color == 'yellow' ? 'border-amber-400' : '' }} {{ 
        $color == 'gray' ? 'border-gray-400' : '' }}">
    <p class="text-gray-500 text-sm dark:text-white">{{ $title }}</p>
    <p class="text-3xl font-semibold mt-2 dark:text-white">{{ $value }}</p>
</div>
