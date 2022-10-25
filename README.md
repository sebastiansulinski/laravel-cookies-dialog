# Laravel Cookie Dialog

This package adds simple functionality to manage cookie dialog on your website.
It consists of the Controller, which expects request to indicate if third party cookies are being allowed or not and sets the cookie on user's machine accordingly.

You can either use your own front end or use the one that comes with the package (vuejs/inertiajs/tailwindcss).

## Installation

```bash
composer require sebastiansulinski/laravel-cookies-dialog

php artisan vendor:publish --tag=laravel-cookies-dialog
```

## Pass shared variables to inertia's view

```bash
// App\Http\Middleware\HandleInertiaRequests.php

public function __construct(Request $request, private Share $share)
{
    //...
}

public function share(Request $request): array
{
    return array_merge(parent::share($request), $this->share->get());
}
```

Included `ServiceProvider` automatically makes all these variables available to all views.

## Adding variables to share

You can add more variables to the sharing pot by using `Share::set()` method from within your `AppServiceProvider`

```php
// App\Providers\AppServiceProvider

use SSD\CookiesDialog\Utilities\Share;

public function boot(): void
{
    Share::set('googleTagID', config('services.google.tag_id'));
}
```

## Usage

Within view file

```html
@if($thirdPartyCookies)
    // your scripts go here
@endif
```

## Js store

### `Pinia` store with `InertiaJs`

```javascript
import { defineStore } from 'pinia';
import { usePage } from '@inertiajs/inertia-vue3';

export const useCookieStore = defineStore('cookies', {
  state: () => ({
    visible: usePage().props.value.showCookiesDialog,
    thirdParty: usePage().props.value.thirdPartyCookies,
  }),
  actions: {
    toggle() {
      this.thirdParty = !this.thirdParty;
    },
    agree() {
      axios.post('/cookie', { third_party: Number(this.thirdParty) })
        .then(() => window.location.reload())
        .catch(error => console.log(error));
    },
  },
});
```

Make sure that `showCookiesDialog` and `thirdPartyCookies` match your configuration variable names if you've overwritten those.

### VueJs `Dialog` component

```javascript
<script setup>
import Settings from './Settings.vue';
import { useCookieStore } from '@/stores/cookies';
import { Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue'

const store = useCookieStore();

const revealed = ref(false);

</script>
<template>
    <div v-if="store.visible" class="w-full fixed inset-x-0 bottom-0 bg-neutral-900 bg-opacity-90 py-8 text-white z-20">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0">
                <div class="flex-auto">
                    <h2 class="text-2xl font-semibold">Cookies</h2>
                    <p class="text-neutral-300 mt-4">
                        We use cookies to help provide you with the best possible online experience.<br />
                        By using this site, you agree that we may store and access cookies on your device.
                    </p>
                    <p class="text-neutral-300 mt-4">
                        <Link
                            href="/cookies"
                            class="text-yellow-300 hover:text-yellow-400"
                        >
                            Cookie policy</Link>.
                        <span
                            @click.prevent="revealed = !revealed"
                            class="text-yellow-300 hover:text-yellow-400 cursor-pointer"
                        >
                            Cookie settings
                        </span>.
                    </p>
                </div>
                <div>
                    <button
                        v-if="!revealed"
                        @click="store.agree"
                        type="button"
                        class="inline-flex rounded-md border px-4 py-2 text-base font-medium shadow-sm bg-white text-gray-800 border-gray-200 hover:border-gray-400"
                    >I Agree</button>
                </div>
            </div>
            <Settings class="py-8" v-if="revealed" />
        </div>
    </div>
</template>
```

### VueJs `Settings` component

```javascript
<script setup>
  import { useCookieStore } from '@/stores/cookies';

  const store = useCookieStore();
</script>
<template>
  <div>
    <div class="grid lg:grid-cols-2 gap-8">
      <div>
        <div class="flex items-center">
          <input
            id="cookies-functional"
            aria-describedby="functional-description"
            name="comments"
            type="checkbox"
            class="h-4 w-4 mr-2 rounded border-neutral-600 border-2 bg-neutral-900 text-primary focus:ring-primary-hover opacity-50"
            checked="checked"
            disabled
          />
          <label for="cookies-functional" class="text-xl text-white">
            Functional cookies
          </label>
        </div>
        <p class="text-neutral-300 mt-6" id="functional-description">
          Functional Cookies are enabled by default at all times so that we can save your preferences for cookie settings and ensure site works and delivers best experience.
        </p>
      </div>
      <div>
        <div class="flex items-center">
          <input
            id="cookies-third-party"
            aria-describedby="third-party-description"
            name="comments"
            type="checkbox"
            class="h-4 w-4 mr-2 rounded border-neutral-600 border-2 bg-neutral-900 text-primary focus:ring-primary-hover"
            @change="store.toggle"
            :checked="store.thirdParty"
          />
          <label for="cookies-third-party" class="text-xl text-white">
            Third party cookies
          </label>
        </div>
        <p class="text-neutral-300 mt-6" id="third-party-description">
          This website uses Google Analytics to collect anonymous information such as the number of visitors to the site, and the most popular pages.
          Keeping this cookie enabled helps us to improve our website.
        </p>
      </div>
    </div>
    <div class="flex justify-end mt-6">
      <button
        type="button"
        @click="store.agree"
        class="inline-flex rounded-md border px-4 py-2 text-base font-medium shadow-sm bg-white text-gray-800 border-gray-200 hover:border-gray-400"
      >Agree to selected</button>
  </div>
</div>
</template>
```