<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'inline-flex items-center justify-center 
                     w-full h-[48px]
                     bg-[#69549F] text-white 
                     rounded-[5px]
                     py-3 
                     gap-[10px]
                     font-semibold text-xs uppercase tracking-widest 
                     border border-transparent 
                     hover:bg-[#5b4a8e] 
                     focus:outline-none focus:ring-2 focus:ring-[#69549F] focus:ring-offset-2 
                     transition ease-in-out duration-150',
    ]) }}>
    {{ $slot }}
</button>
