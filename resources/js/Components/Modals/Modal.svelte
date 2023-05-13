<script>
    import {noScroll} from "@/utils";
    import {fade, scale} from 'svelte/transition';
    import {backIn, backOut} from 'svelte/easing';

    export let showModal;
    export let showFooterMenuOnMobile = true;
    export let title = '';
    export let fullWidthContent = false

    function handleEsc(event) {
        if (event.key === 'Escape') {
            event.preventDefault();
            showModal = false;
        }
    }
</script>

{#if showModal}
    <div {...$$restProps} on:keydown|stopPropagation={handleEsc}
         class="fixed z-10 inset-0 overflow-y-auto"
         role="dialog"
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-12 text-center sm:block sm:p-0">
            <div on:click={() => showModal = false}
                 in:fade={{duration: 300, easing: backOut}}
                 out:fade={{duration: 200, easing: backIn}}
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                 aria-hidden="true"></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div on:click|stopPropagation use:noScroll
                 in:scale={{duration: 300, start: 0.95, easing: backOut}}
                 out:scale={{duration: 200, start: 0.95, easing: backIn}}
                 class="relative inline-block align-bottom w-full bg-white text-left rounded-t-xl shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:rounded-3xl"
                 aria-hidden="true">
                <div class="overflow-hidden sm:rounded-3xl">
                    <div class="bg-white px-4 pt-5 pb-4 sm:pt-8 sm:pb-6 sm:px-8">
                        <div class="grid grid-cols-5 items-end sm:block sm:items-center">
                            <button on:click={() => showModal = false}
                                    class="text-left text-primary-600 focus:outline-none sm:hidden" type="button">
                                Cancel
                            </button>
                            <h3 class="col-span-3 text-lg leading-6 text-center font-semibold text-gray-700 sm:text-left">
                                {title}
                            </h3>
                            <slot name="mobilePrimaryAction">
                                <div></div>
                            </slot>
                        </div>
                        <div class="mt-5" class:-mx-4={fullWidthContent} class:sm:-mx-6={fullWidthContent}>
                            <slot/>
                        </div>
                    </div>
                    <div class={[showFooterMenuOnMobile ? 'flex flex-col' : 'hidden sm:flex',
                     'bg-gray-50 px-4 py-3 sm:flex-row-reverse sm:px-8 sm:border-t sm:border-gray-200'].join(' ').trim()}>
                        <slot name="footer"/>
                    </div>
                </div>

                <div class="absolute top-0 inset-x-0 flex justify-center">
                    <div class="-mt-7 p-3 bg-red-50 text-red-900 border border-black/10 rounded-full shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
