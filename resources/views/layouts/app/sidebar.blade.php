<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <div class="flex flex-col gap-6 py-3">
            <div class="rounded-xl border bg-white dark:bg-stone-950 dark:border-stone-800 text-stone-800 shadow-xs">
                <div class="px-10 py-10 bg-zinc-200 flex justify-between items-center">
                    <div class="text-2xl font-bold">
                        Bienvenue à la gare de
                        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-teal-400">
                            {{ auth()->user()->gare->gare }}
                        </h1>
                    </div>
                    <div class="flex items-center gap-4">
                        <flux:badge rounded icon="archive-box" >
                             <flux:link :href="route('colisPosseder.depotColisVersGare')" variant="subtle">{{ $nbreDepot }} Depot</flux:link>
                        </flux:badge>
                        <flux:badge rounded icon="arrow-right-circle" > 
                            <flux:link :href="route('colisPosseder.colisEnCoursVersGare')" variant="subtle">{{ $nbreEnCours }}  Encours</flux:link>
                        </flux:badge>
                        <flux:badge rounded icon="archive-box-arrow-down" >
                            <flux:link :href="route('colisPosseder.colisArriverVersGare')" variant="subtle">{{ $nbreArriver }}  Arriver</flux:link>
                        </flux:badge>
                         <flux:badge rounded icon="archive-box-arrow-down" >
                            <flux:link :href="route('colisPosseder.colisAnnulerVersGare')" variant="subtle">{{ $nbreAnnuler }}  Annuler</flux:link>
                        </flux:badge>
                    </div>
                    <div class="flex items-center gap-4">
                        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
                    </div>
                </div>
            </div>
        </div>
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <div class="my-2 py-2 border-t border-zinc-200 dark:border-zinc-700">
                        <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Acceuil') }}
                        </flux:sidebar.item>
                    </div>
                    <div class="my-2 py-2 border-t border-zinc-200 dark:border-zinc-700 ">
                        <flux:sidebar.item  icon="users" :href="route('colis.create')" :current="request()->routeIs('colis.*')" wire:navigate>
                            {{ __('Colis') }}
                        </flux:sidebar.item>
                    </div>
                    <div class="my-2 py-2 border-t border-zinc-200 dark:border-zinc-700">
                        <flux:sidebar.item icon="home" :href="route('gares.index')" :current="request()->routeIs('gares.*')" wire:navigate>
                            {{ __('Gares') }}
                        </flux:sidebar.item>
                    </div>
                    <div class="my-2 py-2 border-t border-zinc-200 dark:border-zinc-700">
                        <flux:navlist.group heading="Recuperation" expandable collapsed>
                            <flux:navlist.item icon="home" :href="route('recupererColis.recuperationColis')" :current="request()->routeIs('recupererColis.*')" wire:navigate>
                                {{ __('Recuperer Colis') }}
                            </flux:navlist.item>
                            <flux:navlist.item icon="home" :href="route('colisPosseder.colisArriverGare')" :current="request()->routeIs('colisPosseder.colisArriverGare')" wire:navigate>
                                {{ __('Colis Arriver') }}
                            </flux:navlist.item>
                        </flux:navlist.group>
                    </div>
                    <div class="my-2 py-2 border-t border-zinc-200 dark:border-zinc-700">
                        <flux:sidebar.item icon="home" :href="route('recupererColis.colisRendus')" :current="request()->routeIs('recupererColis.*')" wire:navigate>
                            {{ __('Colis Rendu') }}
                        </flux:sidebar.item>
                    </div>
                    <div class="my-2 py-2 border-t border-zinc-200 dark:border-zinc-700">
                        <flux:sidebar.item icon="home" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>
                            {{ __('Utilisateur') }}
                        </flux:sidebar.item>
                    </div>
                    <div class="my-2 py-2 border-t border-zinc-200 dark:border-zinc-700">
                        <flux:sidebar.item icon="home" :href="route('type_colis.index')" :current="request()->routeIs('type_colis*')" wire:navigate>
                            {{ __('Type de Colis') }}
                        </flux:sidebar.item>
                    </div>
                    <div class="my-2 py-2 border-t border-zinc-200 dark:border-zinc-700">
                        <flux:sidebar.item icon="home" :href="route('colisPosseder.colisAnnulerDefinitive')" :current="request()->routeIs('colisPosseder.colisAnnulerGare')" wire:navigate>
                                {{ __('Colis Annuler') }}
                        </flux:sidebar.item>
                    </div>
                    <div class="my-2 py-2 border-t border-zinc-200 dark:border-zinc-700">
                        <flux:navlist.group heading="Autorisations" expandable >
                            <flux:navlist.item icon="home" :href="route('permissions.index')" :current="request()->routeIs('permissions.*')" wire:navigate>Permissions</flux:navlist.item>
                            <flux:navlist.item icon="home" :href="route('roles.index')" :current="request()->routeIs('roles.*')" wire:navigate>Roles</flux:navlist.item>
                        </flux:navlist.group>
                    </div> 
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

           
        </flux:sidebar>


        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
