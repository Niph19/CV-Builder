<x-app-shell
    :title="'Data Diri — '.config('app.name')"
    :eyebrow="'Profil '.Auth::user()->role->label()"
    heading="Data diri"
    description="Lengkapi data diri Anda. Data ini menjadi sumber utama pembuatan CV dan analisis AI."
>
    <x-slot name="headingActions">
        <a href="{{ route('profile.edit') }}"
            class="inline-flex w-fit items-center gap-2 rounded-xl border border-mint/30 bg-forest/70 px-4 py-2 text-sm font-medium text-fog shadow-sm transition hover:border-mint/60 hover:text-white">
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Pengaturan akun
        </a>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start">
        <div class="space-y-6">
            <div class="rounded-2xl border border-forest/10 bg-mist/95 p-6 shadow-[0_24px_60px_rgba(7,23,17,0.18)] sm:p-8">
                <div class="mb-6 flex items-center gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-mint/20 text-moss">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 10a3 3 0 100-6 3 3 0 000 6zM3.5 17a6.5 6.5 0 0113 0 .75.75 0 01-.75.75h-11.5A.75.75 0 013.5 17z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="font-display text-lg font-semibold text-ink">Identitas &amp; pendidikan</h2>
                        <p class="text-sm text-forest/60">Data dasar yang dipakai pada CV.</p>
                    </div>
                </div>

                @if (session('status') === 'profile-data-updated')
                    <div class="mb-6 flex items-center gap-3 rounded-xl border border-moss/20 bg-mint/15 px-4 py-3 text-sm text-forest">
                        <svg class="h-5 w-5 shrink-0 text-moss" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Data diri berhasil disimpan.
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.data.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-field for="phone" label="Nomor HP" :error="$errors->first('phone')">
                            <x-text-input id="phone" name="phone" type="tel" :value="old('phone', $profile->phone)" class="block w-full" autocomplete="tel" placeholder="0812-3456-7890" />
                        </x-field>

                        <x-field for="school_major" label="Jurusan" :error="$errors->first('school_major')" required>
                            <x-text-input id="school_major" name="school_major" :value="old('school_major', $profile->school_major)" class="block w-full" placeholder="Contoh: DKV" required />
                        </x-field>

                        <x-field for="graduation_year" label="Tahun lulus" :error="$errors->first('graduation_year')">
                            <x-text-input id="graduation_year" name="graduation_year" type="number" :value="old('graduation_year', $profile->graduation_year)" class="block w-full" inputmode="numeric" placeholder="{{ date('Y') }}" />
                        </x-field>

                        <x-field for="address" label="Alamat" :error="$errors->first('address')" class="sm:col-span-2">
                            <x-textarea id="address" name="address" rows="2">{{ old('address', $profile->address) }}</x-textarea>
                        </x-field>

                        <x-field for="education" label="Pendidikan" :error="$errors->first('education')" class="sm:col-span-2">
                            <x-textarea id="education" name="education" rows="3" placeholder="SMK Informatika Pesat — DKV (2023–2026)">{{ old('education', $profile->education) }}</x-textarea>
                        </x-field>
                    </div>

                    <div class="border-t border-forest/10 pt-6">
                        <div class="mb-6 flex items-center gap-3">
                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-xl bg-clay/10 text-clay">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.95 22.95 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="font-display text-lg font-semibold text-ink">Pengalaman &amp; skill</h2>
                                <p class="text-sm text-forest/60">Tuliskan secara ringkas, dipisah koma atau baris baru.</p>
                            </div>
                        </div>

                        <div class="grid gap-5">
                            <x-field for="experience" label="Pengalaman" :error="$errors->first('experience')">
                                <x-textarea id="experience" name="experience" rows="4" placeholder="PKL di ..., proyek ...">{{ old('experience', $profile->experience) }}</x-textarea>
                            </x-field>

                            <x-field for="skills" label="Skill" :error="$errors->first('skills')" required>
                                <x-textarea id="skills" name="skills" rows="3" placeholder="Photoshop, Illustrator, Editing Video, UI Design" required>{{ old('skills', $profile->skills) }}</x-textarea>
                            </x-field>
                        </div>
                    </div>

                    <div class="border-t border-forest/10 pt-6">
                        <h2 class="mb-4 font-display text-lg font-semibold text-ink">Tautan</h2>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <x-field for="portfolio_url" label="Link portofolio" :error="$errors->first('portfolio_url')">
                                <x-text-input id="portfolio_url" name="portfolio_url" type="url" :value="old('portfolio_url', $profile->portfolio_url)" class="block w-full" placeholder="https://" />
                            </x-field>

                            <x-field for="linkedin_url" label="Link LinkedIn" :error="$errors->first('linkedin_url')">
                                <x-text-input id="linkedin_url" name="linkedin_url" type="url" :value="old('linkedin_url', $profile->linkedin_url)" class="block w-full" placeholder="https://" />
                            </x-field>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 border-t border-forest/10 pt-6">
                        <p class="text-xs text-forest/60">Field bertanda <span class="font-semibold text-clay">*</span> wajib diisi.</p>
                        <x-primary-button>Simpan data diri</x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <aside class="space-y-4 lg:sticky lg:top-6">
            <div class="rounded-2xl border border-forest/10 bg-white p-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wider text-forest/50">Kelengkapan profil</p>

                @php
                    $fields = [
                        'Nomor HP' => $profile->phone,
                        'Jurusan' => $profile->school_major,
                        'Alamat' => $profile->address,
                        'Pendidikan' => $profile->education,
                        'Pengalaman' => $profile->experience,
                        'Skill' => $profile->skills,
                        'Portofolio' => $profile->portfolio_url,
                        'LinkedIn' => $profile->linkedin_url,
                    ];
                    $filled = collect($fields)->filter(fn ($value) => filled($value))->count();
                    $total = count($fields);
                    $percent = (int) round($filled / $total * 100);
                @endphp

                <div class="mt-3 flex items-end justify-between">
                    <span class="font-display text-3xl font-semibold text-ink">{{ $percent }}%</span>
                    <span class="text-xs text-forest/60">{{ $filled }}/{{ $total }} terisi</span>
                </div>

                <div class="mt-3 h-2 overflow-hidden rounded-full bg-fog">
                    <div class="h-full rounded-full bg-moss transition-all" style="width: {{ $percent }}%"></div>
                </div>

                <ul class="mt-5 space-y-2 text-sm">
                    @foreach ($fields as $label => $value)
                        <li class="flex items-center gap-2 {{ filled($value) ? 'text-forest' : 'text-forest/45' }}">
                            <svg class="h-4 w-4 shrink-0 {{ filled($value) ? 'text-moss' : 'text-forest/25' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                @if (filled($value))
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                @else
                                    <circle cx="10" cy="10" r="3" />
                                @endif
                            </svg>
                            <span>{{ $label }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="rounded-2xl border border-forest/10 bg-forest p-5 text-fog shadow-sm">
                <p class="font-display text-sm font-semibold text-white">Tips</p>
                <p class="mt-2 text-sm leading-relaxed text-fog/80">
                    Tulis skill dan pengalaman dengan kata kerja dan hasil nyata, misalnya
                    &ldquo;membuat desain feed Instagram 30 konten/bulan&rdquo;.
                </p>
            </div>
        </aside>
    </div>
</x-app-shell>
