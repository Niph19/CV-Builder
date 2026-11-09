<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium uppercase tracking-wider text-moss">Data Diri</p>
                <h2 class="font-display text-xl font-semibold text-ink">Profil {{ Auth::user()->role->label() }}</h2>
            </div>
            <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-moss hover:text-forest">&larr; Pengaturan akun</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-forest/10 bg-white p-6 shadow-sm sm:p-8">
                <p class="mb-6 text-sm text-forest/70">
                    Data ini dipakai sebagai sumber pembuatan CV dan analisis AI pada sprint berikutnya.
                </p>

                @if (session('status') === 'profile-data-updated')
                    <div class="mb-6 rounded-lg bg-mint/15 px-4 py-3 text-sm text-moss">Data diri berhasil disimpan.</div>
                @endif

                <form method="POST" action="{{ route('profile.data.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <x-input-label for="phone" value="Nomor HP" />
                            <x-text-input id="phone" name="phone" type="tel" :value="old('phone', $profile->phone)" class="mt-1 block w-full" autocomplete="tel" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="school_major" value="Jurusan" />
                            <x-text-input id="school_major" name="school_major" :value="old('school_major', $profile->school_major)" class="mt-1 block w-full" placeholder="Contoh: DKV" required />
                            <x-input-error :messages="$errors->get('school_major')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="graduation_year" value="Tahun lulus" />
                            <x-text-input id="graduation_year" name="graduation_year" type="number" :value="old('graduation_year', $profile->graduation_year)" class="mt-1 block w-full" inputmode="numeric" />
                            <x-input-error :messages="$errors->get('graduation_year')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="address" value="Alamat" />
                        <textarea id="address" name="address" rows="2" class="mt-1 block w-full rounded-lg border-forest/25 bg-white text-ink shadow-sm focus:border-moss focus:ring-moss">{{ old('address', $profile->address) }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="education" value="Pendidikan" />
                        <textarea id="education" name="education" rows="3" class="mt-1 block w-full rounded-lg border-forest/25 bg-white text-ink shadow-sm focus:border-moss focus:ring-moss" placeholder="SMK Informatika Pesat — DKV (2023–2026)">{{ old('education', $profile->education) }}</textarea>
                        <x-input-error :messages="$errors->get('education')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="experience" value="Pengalaman" />
                        <textarea id="experience" name="experience" rows="4" class="mt-1 block w-full rounded-lg border-forest/25 bg-white text-ink shadow-sm focus:border-moss focus:ring-moss" placeholder="PKL di ..., proyek ...">{{ old('experience', $profile->experience) }}</textarea>
                        <x-input-error :messages="$errors->get('experience')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="skills" value="Skill" />
                        <textarea id="skills" name="skills" rows="3" class="mt-1 block w-full rounded-lg border-forest/25 bg-white text-ink shadow-sm focus:border-moss focus:ring-moss" placeholder="Photoshop, Illustrator, Editing Video, UI Design" required>{{ old('skills', $profile->skills) }}</textarea>
                        <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <x-input-label for="portfolio_url" value="Link portofolio" />
                            <x-text-input id="portfolio_url" name="portfolio_url" type="url" :value="old('portfolio_url', $profile->portfolio_url)" class="mt-1 block w-full" placeholder="https://" />
                            <x-input-error :messages="$errors->get('portfolio_url')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="linkedin_url" value="Link LinkedIn" />
                            <x-text-input id="linkedin_url" name="linkedin_url" type="url" :value="old('linkedin_url', $profile->linkedin_url)" class="mt-1 block w-full" placeholder="https://" />
                            <x-input-error :messages="$errors->get('linkedin_url')" class="mt-2" />
                        </div>
                    </div>

                    <x-primary-button>Simpan data diri</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
