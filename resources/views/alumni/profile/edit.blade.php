<x-app-shell
    :title="'Profil Alumni — '.config('app.name')"
    heading="Data alumni"
    description="Perbarui informasi kelulusan dan aktivitas Anda agar sekolah dapat menjaga data alumni tetap akurat."
>
    <div class="mx-auto max-w-4xl">
        <div class="overflow-hidden rounded-2xl border border-forest/10 bg-mist/95 shadow-[0_24px_60px_rgba(7,23,17,0.18)]">
            <div class="border-b border-forest/10 px-6 py-5 sm:px-8">
                <h2 class="font-display text-lg font-semibold text-ink">Informasi diri</h2>
                <p class="mt-1 text-sm text-forest/70">Lengkapi data di bawah. Informasi bertanda <span class="font-semibold text-clay">*</span> wajib diisi.</p>
            </div>

            @if (session('status') === 'alumni-profile-updated')
                <div role="status" class="mx-6 mt-6 flex items-center gap-3 rounded-xl border border-moss/20 bg-mint/15 px-4 py-3 text-sm text-forest sm:mx-8">
                    <svg class="h-5 w-5 shrink-0 text-moss" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Data alumni berhasil disimpan.
                </div>
            @endif

            <form method="POST" action="{{ route('alumni.profile.update') }}" class="space-y-7 px-6 py-6 sm:px-8">
                @csrf
                @method('PUT')

                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field for="nama_lengkap" label="Nama lengkap" :error="$errors->first('nama_lengkap')" required>
                        <x-text-input id="nama_lengkap" name="nama_lengkap" :value="old('nama_lengkap', $profile->nama_lengkap ?: auth()->user()->name)" class="block w-full placeholder:text-forest/70" autocomplete="name" required />
                    </x-field>

                    <x-field for="jurusan" label="Jurusan" :error="$errors->first('jurusan')" required>
                        <x-text-input id="jurusan" name="jurusan" :value="old('jurusan', $profile->jurusan)" class="block w-full placeholder:text-forest/70" placeholder="Contoh: Rekayasa Perangkat Lunak" required />
                    </x-field>

                    <x-field for="tahun_lulus" label="Tahun lulus" :error="$errors->first('tahun_lulus')" required>
                        <x-text-input id="tahun_lulus" name="tahun_lulus" type="number" :value="old('tahun_lulus', $profile->tahun_lulus)" class="block w-full placeholder:text-forest/70" min="1900" max="{{ now()->year }}" inputmode="numeric" placeholder="{{ now()->year }}" required />
                    </x-field>

                    <x-field for="status_saat_ini" label="Status saat ini" :error="$errors->first('status_saat_ini')" required>
                        <select id="status_saat_ini" name="status_saat_ini" class="mt-1 block w-full rounded-lg border-forest/25 bg-white text-ink shadow-sm focus:border-moss focus:ring-moss" required>
                            <option value="" disabled @selected(old('status_saat_ini', $profile->status_saat_ini) === null)>Pilih status</option>
                            <option value="bekerja" @selected(old('status_saat_ini', $profile->status_saat_ini) === 'bekerja')>Bekerja</option>
                            <option value="kuliah" @selected(old('status_saat_ini', $profile->status_saat_ini) === 'kuliah')>Kuliah</option>
                            <option value="wirausaha" @selected(old('status_saat_ini', $profile->status_saat_ini) === 'wirausaha')>Wirausaha</option>
                            <option value="mencari_kerja" @selected(old('status_saat_ini', $profile->status_saat_ini) === 'mencari_kerja')>Mencari kerja</option>
                            <option value="lainnya" @selected(old('status_saat_ini', $profile->status_saat_ini) === 'lainnya')>Lainnya</option>
                        </select>
                    </x-field>
                </div>

                <div class="border-t border-forest/10 pt-6">
                    <h3 class="font-display text-base font-semibold text-ink">Aktivitas dan kontak</h3>
                    <p class="mt-1 text-sm text-forest/65">Bagian ini opsional dan dapat diperbarui kapan saja.</p>

                    <div class="mt-5 grid gap-5 sm:grid-cols-2">
                        <x-field for="nama_instansi" label="Nama instansi" :error="$errors->first('nama_instansi')">
                            <x-text-input id="nama_instansi" name="nama_instansi" :value="old('nama_instansi', $profile->nama_instansi)" class="block w-full placeholder:text-forest/70" autocomplete="organization" placeholder="Nama perusahaan atau kampus" />
                        </x-field>

                        <x-field for="jabatan" label="Jabatan atau program studi" :error="$errors->first('jabatan')">
                            <x-text-input id="jabatan" name="jabatan" :value="old('jabatan', $profile->jabatan)" class="block w-full placeholder:text-forest/70" placeholder="Contoh: Desainer Grafis atau Teknik Informatika" />
                        </x-field>

                        <x-field for="no_hp" label="Nomor HP" :error="$errors->first('no_hp')">
                            <x-text-input id="no_hp" name="no_hp" type="tel" :value="old('no_hp', $profile->no_hp)" class="block w-full placeholder:text-forest/70" autocomplete="tel" placeholder="0812-3456-7890" />
                        </x-field>

                        <x-field for="alamat" label="Alamat" :error="$errors->first('alamat')" class="sm:col-span-2">
                            <x-textarea id="alamat" name="alamat" rows="3" autocomplete="street-address" placeholder="Kota atau alamat domisili" class="placeholder:text-forest/70">{{ old('alamat', $profile->alamat) }}</x-textarea>
                        </x-field>
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-forest/10 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-forest/65">Data ini membantu sekolah menjaga pendataan alumni tetap akurat.</p>
                    <x-primary-button class="justify-center">Simpan data alumni</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-shell>
