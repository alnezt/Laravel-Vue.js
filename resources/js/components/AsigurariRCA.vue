<template>
    <div class="form-container">
        <!-- Autentificare -->
        <div class="auth-section">
            <button @click="handleLogin" type="button" class="login-btn">Autentifică-te</button>
            <span v-if="isAuthenticated" class="token-indicator">✅ Autentificat</span>
            <span v-else class="token-indicator">🔒 Neautentificat</span>
        </div>

        <h2>Introduceți oferta în formular</h2>
        <form @submit.prevent="submitForm" class="insurance-form">
            <!-- Date Asigurare -->
            <div class="form-section">
                <h3>Datele asigurării</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Data de început*</label>
                        <input type="date" v-model="formData.product.motor.startDate" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Durata valabilitate (luni)*</label>
                        <input type="number" v-model="formData.product.motor.termTime" required class="form-input" />
                    </div>
                </div>
            </div>

            <!-- Date Proprietar -->
            <div class="form-section">
                <h3>Date proprietar/asigurat</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Nume*</label>
                        <input v-model="formData.product.policyholder.lastName" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Prenume*</label>
                        <input v-model="formData.product.policyholder.firstName" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>CNP*</label>
                        <input v-model="formData.product.policyholder.taxId" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Data nașterii*</label>
                        <input type="date" v-model="formData.product.policyholder.birthdate" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Email*</label>
                        <input type="email" v-model="formData.product.policyholder.email" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Telefon*</label>
                        <input v-model="formData.product.policyholder.mobileNumber" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Naționalitate*</label>
                        <input v-model="formData.product.policyholder.nationality" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Cetățenie*</label>
                        <input v-model="formData.product.policyholder.citizenship" required class="form-input" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Gen*</label>
                    <select v-model="formData.product.policyholder.gender" required class="form-input">
                        <option value="m">Masculin</option>
                        <option value="f">Feminin</option>
                    </select>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Persoană străină</label>
                        <input type="checkbox" v-model="formData.product.policyholder.isForeignPerson" class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Persoană cu dizabilități</label>
                        <input type="checkbox" v-model="formData.product.policyholder.hasDisability" class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Pensionar</label>
                        <input type="checkbox" v-model="formData.product.policyholder.isRetired" class="form-input" />
                    </div>
                </div>

                <h4>Act identitate</h4>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tip act*</label>
                        <select v-model="formData.product.policyholder.identification.idType" required class="form-input">
                            <option value="CI">Carte de identitate</option>
                            <option value="BI">Buletin de identitate</option>
                            <option value="PAS">Pașaport</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Număr act*</label>
                        <input v-model="formData.product.policyholder.identification.idNumber" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Eliberat de*</label>
                        <input v-model="formData.product.policyholder.identification.issueAuthority" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Data eliberării*</label>
                        <input type="date" v-model="formData.product.policyholder.identification.issueDate" required class="form-input" />
                    </div>
                </div>

                <h4>Permis conducere</h4>
                <div class="form-group">
                    <label>Data eliberării*</label>
                    <input type="date" v-model="formData.product.policyholder.drivingLicense.issueDate" required class="form-input" />
                </div>

                <h4>Adresă</h4>
                <div class="form-row">
                    <div class="form-group">
                        <label>Țară*</label>
                        <input v-model="formData.product.policyholder.address.country" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Județ*</label>
                        <input v-model="formData.product.policyholder.address.county" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Localitate*</label>
                        <input v-model="formData.product.policyholder.address.city" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Cod localitate*</label>
                        <input type="number" v-model="formData.product.policyholder.address.cityCode" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Stradă*</label>
                        <input v-model="formData.product.policyholder.address.street" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Număr*</label>
                        <input v-model="formData.product.policyholder.address.houseNumber" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Bloc</label>
                        <input v-model="formData.product.policyholder.address.building" class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Etaj</label>
                        <input type="number" v-model="formData.product.policyholder.address.floor" class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Scara</label>
                        <input v-model="formData.product.policyholder.address.staircase" class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Apartament</label>
                        <input v-model="formData.product.policyholder.address.apartment" class="form-input" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Cod poștal*</label>
                    <input v-model="formData.product.policyholder.address.postcode" required class="form-input" />
                </div>
            </div>

            <!-- Date Vehicul -->
            <div class="form-section">
                <h3>Date vehicul</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tip înmatriculare*</label>
                        <select v-model="formData.product.vehicle.registrationType" required class="form-input">
                            <option value="registered">Înmatriculat</option>
                            <option value="temporary">Înmatriculare temporară</option>
                            <option value="new">Mașină nouă</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Număr înmatriculare*</label>
                        <input v-model="formData.product.vehicle.licensePlate" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>VIN (șasiu)*</label>
                        <input v-model="formData.product.vehicle.vin" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Tip vehicul*</label>
                        <select v-model="formData.product.vehicle.vehicleType" required class="form-input">
                            <option value="M1">Autoturism (M1)</option>
                            <option value="N1">Autoutilitară (N1)</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Marcă*</label>
                        <input v-model="formData.product.vehicle.brand" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Model*</label>
                        <input v-model="formData.product.vehicle.model" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>An fabricație*</label>
                        <input v-model="formData.product.vehicle.yearOfConstruction" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Prima înmatriculare*</label>
                        <input type="date" v-model="formData.product.vehicle.firstRegistration" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Cilindree (cm³)*</label>
                        <input type="number" v-model="formData.product.vehicle.engineDisplacement" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Putere (CP)*</label>
                        <input type="number" v-model="formData.product.vehicle.enginePower" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Număr locuri*</label>
                        <input type="number" v-model="formData.product.vehicle.seats" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Greutate totală (kg)*</label>
                        <input type="number" v-model="formData.product.vehicle.totalWeight" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Combustibil*</label>
                        <select v-model="formData.product.vehicle.fuelType" required class="form-input">
                            <option value="petrol">Benzină</option>
                            <option value="diesel">Motorină</option>
                            <option value="hybrid">Hybrid</option>
                            <option value="electric">Electric</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Utilizare*</label>
                        <select v-model="formData.product.vehicle.usageType" required class="form-input">
                            <option value="personal">Personal</option>
                            <option value="commercial">Comercial</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Kilometraj*</label>
                        <input type="number" v-model="formData.product.vehicle.currentMileage" required class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Număr identificare*</label>
                        <input v-model="formData.product.vehicle.identification.idNumber" required class="form-input" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Modificări pentru mobilitate</label>
                        <input type="checkbox" v-model="formData.product.vehicle.hasMobilityModifications" class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Închiriat</label>
                        <input type="checkbox" v-model="formData.product.vehicle.isLeased" class="form-input" />
                    </div>
                </div>

            </div>

            <!-- Date Adiționale -->
            <div class="form-section">
                <h3>Date adiționale</h3>
                <div class="form-group">
                    <label>Data expirare înmatriculare temporară</label>
                    <input type="date" v-model="formData.product.additionalData.product.vehicle.expirationDatePti" class="form-input" />
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Număr daune anterioare</label>
                        <input type="number" v-model="formData.product.additionalData.product.bonusMalusClaimsNo" class="form-input" />
                    </div>
                    <div class="form-group">
                        <label>Clasă bonus-malus anterioară</label>
                        <input v-model="formData.product.additionalData.product.bonusMalusPrevClass" class="form-input" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Șofer tânăr (sub 25 ani)</label>
                    <input type="checkbox" v-model="formData.product.additionalData.product.noYoungDriver" class="form-input" />
                </div>
            </div>

            <!-- Submit -->
            <div class="form-actions">
                <button type="submit" class="submit-btn">Trimite oferta</button>
                <button type="button" @click="resetForm" class="reset-btn">Resetează</button>
            </div>
        </form>


    </div>


    <div v-if="apiResponses.error">
        <p>Eroare: {{ apiResponses.message }}</p>
    </div>
    <div v-else-if="apiResponses.offers && apiResponses.offers.length" class="offers-wrapper">
        <h3>Oferte primite:</h3>
        <div class="offers-grid">
            <div v-for="(offer, index) in apiResponses.offers" :key="index" class="offer-card" :class="offer.status">
                <div class="card-header">
                    <div class="insurer-name">{{ offer.insurer }}</div>
                    <div class="status-badge" :data-status="offer.status">
                        <span v-if="offer.status === 'success'">Success</span>
                        <span v-else>Error</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="field">
                        <div class="label">Acțiuni:</div>
                        <div class="value" style="text-align: right;">
                            <button
                                type="button"
                                class="pdf-download-btn"
                                @click="downloadOfferPDF(offer.offerId, offer.insurer, offer.pid, $event)"
                                :disabled="!offer.offerId"
                            >
                                Descarcă PDF
                            </button>
                        </div>
                    </div>


                    <div class="field">
                        <div class="label">Premium:</div>
                        <div class="value">
                            <template v-if="offer.status === 'success'">
                                {{ offer.premium }} <small>RON</small>
                                <button
                                    @click="handleCreatePolicy(offer)"
                                    :disabled="offer.isCreatingPolicy"
                                >
                                    {{ offer.isCreatingPolicy ? 'Se procesează...' : 'Generează polița' }}
                                </button>
                                <button
                                    @click="downloadPolicyPDF(offer.policyId)"
                                    :disabled="!offer.policyId"
                                    v-if="offer.policyId"
                                >
                                    Descarcă polița
                                </button>
                            </template>
                            <template v-else>
                                N/A
                            </template>
                        </div>
                    </div>
                    <div class="field" v-if="offer.status === 'error'">
                        <div class="label">Eroare:</div>
                        <div class="value error-text">{{ offer.message }}</div>
                    </div>
                    <div class="field" v-if="offer.pid">
                        <div class="label">PID:</div>
                        <div class="value">
                            <a :href="offer.pid" target="_blank" rel="noopener" class="pid-link">Vizualizează</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import axios from 'axios'

const isAuthenticated = ref(false)

onMounted(() => {
    isAuthenticated.value = !!localStorage.getItem('rca_token')
})

const handleLogin = async () => {
    try {
        const res = await fetch('https://rca-qa.api.lifeishard.ro/auth', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                account: 'xiga_dev',
                password: 'xoxvyc-0wejjo-quxkuD'
            })
        })
        const json = await res.json()
        if (!res.ok) throw new Error(json.message || 'Eroare necunoscută')
        localStorage.setItem('rca_token', json.data.token)
        isAuthenticated.value = true
        alert('Autentificare reușită!')
    } catch (e) {
        alert('Eroare la autentificare: ' + e.message)
    }
}

const resetForm = () => {
    Object.assign(formData, getDefaultFormData())
}


const getDefaultFormData = () => ({
    provider: {
        organization: {
            businessName: "generali"
        },
        authentication: {
            account: "",
            password: "",
            code: ""
        }
    },
    product: {
        motor: {
            startDate: "",
            termTime: 1
        },
        policyholder: {
            lastName: "",
            firstName: "",
            isForeignPerson: false,
            taxId: "",
            nationality: "RO",
            citizenship: "RO",
            gender: "m",
            birthdate: "",
            email: "",
            mobileNumber: "",
            identification: {
                idType: "CI",
                idNumber: "",
                issueAuthority: "",
                issueDate: ""
            },
            drivingLicense: {
                issueDate: ""
            },
            address: {
                country: "RO",
                county: "CT",
                city: "MANGALIA",
                cityCode: "",
                street: "",
                houseNumber: "",
                building: "",
                floor: "",
                staircase: "",
                apartment: "",
                postcode: ""
            },
            hasDisability: false,
            isRetired: false
        },
        vehicle: {
            registrationType: "registered",
            licensePlate: "",
            vin: "",
            vehicleType: "M1",
            brand: "",
            model: "",
            yearOfConstruction: "",
            engineDisplacement: 0,
            seats: 5,
            enginePower: 0,
            totalWeight: 0,
            fuelType: "petrol",
            firstRegistration: "",
            usageType: "personal",
            identification: {
                idNumber: ""
            },
            currentMileage: 0,
            hasMobilityModifications: false,
            isLeased: false
        },
        additionalData: {
            product: {
                vehicle: {
                    expirationDatePti: ""
                },
                bonusMalusClaimsNo: 0,
                bonusMalusPrevClass: "B0",
                noYoungDriver: false
            }
        }
    }
})

const formData = reactive(getDefaultFormData())
const apiResponses = ref({}); // Inițializăm cu un obiect gol



const submitForm = async () => {
    try {
        const response = await axios.post('/api/offer', formData, {
            headers: {
                'Token': localStorage.getItem('rca_token'),
                'Content-Type': 'application/json'
            }
        });

        console.log('Raw response data:', response.data); // debug: vezi forma exactă

        let offers = [];

        if (Array.isArray(response.data.offers)) {
            // structura „nouă” cu array de offers
            offers = response.data.offers.map(o => ({
                insurer: o.insurer,
                status: o.status,
                premium: o.premium ?? null,
                offerId: o.offerId ?? null, // corect
                message: o.message ?? null,
                pid: o.pid ?? null
            }));
        } else {
            // fallback: structura per-insurer (asirom, axeria, etc.)
            for (const [key, info] of Object.entries(response.data)) {
                if (['message', 'offer_id'].includes(key)) continue; // skip meta
                if (!info || typeof info !== 'object') continue;

                if (info.success) {
                    // extrage premium: prioritate din payload-ul intern sau fallback la premiumAmount
                    const offerObj = info.data?.data?.offers?.[0] ?? {};
                    const premium = offerObj.premiumAmount ?? info.premiumAmount ?? null;
                    offers.push({
                        insurer: key,
                        status: 'success',
                        premium,
                        offerId: offerObj?.offerId ?? null,
                        pid: offerObj.pid || null
                    });
                } else {
                    offers.push({
                        insurer: key,
                        status: 'error',
                        message: info.error_message || 'Eroare necunoscută'
                    });
                }
            }
        }

        if (offers.length === 0) {
            apiResponses.value = {
                error: true,
                message: 'Nu s-au primit oferte valide de la server.'
            };
        } else {
            apiResponses.value = { offers };
        }
    } catch (error) {
        const apiError = error.response?.data;
        apiResponses.value = {
            error: true,
            message: apiError?.message || error.message || 'Eroare necunoscută',
            details: apiError?.errors || null
        };
        console.error('submitForm error:', error);
    }
};


const downloadOfferPDF = async (offerId, insurerName, pidFallback, event) => {
    try {
        if (event?.preventDefault) event.preventDefault();
        if (!offerId) throw new Error('Lipsește offerId-ul.');

        const token = localStorage.getItem('rca_token');
        if (!token) throw new Error('Token lipsă.');

        const response = await fetch(`https://rca-qa.api.lifeishard.ro/offer/${offerId}`, {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Token: token,
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            const errData = await response.json().catch(() => ({}));
            throw new Error(`Eroare ${response.status}: ${errData.message || 'Nedefinită'}`);
        }

        const json = await response.json();
        const file = json.data?.files?.find(f => f.type === 'Offer');
        if (!file?.content) throw new Error('PDF-ul nu a fost găsit.');

        const byteCharacters = atob(file.content);
        const byteNumbers = new Array(byteCharacters.length);
        for (let i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
        }
        const blob = new Blob([new Uint8Array(byteNumbers)], { type: 'application/pdf' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        const safeName = (file.name || `oferta_${insurerName}_${offerId}`).replace(/\s+/g, '_');
        a.download = `${safeName}.pdf`;
        document.body.appendChild(a);
        a.click();
        setTimeout(() => {
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }, 150);
    } catch (e) {
        console.error('Eroare descărcare PDF:', e);
        if (pidFallback) {
            window.open(pidFallback, '_blank');
        } else {
            alert('Eroare la descărcare: ' + e.message);
        }
    }
};



const handleCreatePolicy = async (offer) => {
    try {
        offer.isCreatingPolicy = true // Afișează stare de încărcare

        const result = await createPolicy(offer)
        if (result.success) {
            // Actualizează oferta cu ID-ul poliței
            offer.policyId = result.policyId
            alert('Polița a fost creată cu succes! Acum poți descărca PDF-ul.')
        }
    } catch (error) {
        console.error('Eroare la crearea poliței:', error)
        alert(`Eroare: ${error.message || 'Nu s-a putut crea polița'}`)
    } finally {
        offer.isCreatingPolicy = false
    }
}

const createPolicy = async (offer) => {
    try {
        const token = localStorage.getItem('rca_token')
        if (!token) throw new Error('Autentificare necesară')

        const payload = {
            offerId: offer.offerId,
            includeDirectCompesation: false,
            payment: {
                method: 'receipt',
                currency: 'RON',
                amount: offer.premium,
                date: new Date().toISOString().split('T')[0],
                documentNumber: `DOC-${Date.now().toString().slice(-6)}`
            }
        }

        const response = await axios.post(
            'https://rca-qa.api.lifeishard.ro/policy',
            payload,
            {
                headers: {
                    'Token': token,
                    'Content-Type': 'application/json'
                }
            }
        )

        if (!response.data?.data?.policies?.[0]?.policyId) {
            throw new Error('ID-ul poliței nu a fost returnat')
        }

        return {
            success: true,
            policyId: response.data.data.policies[0].policyId,
            message: 'Polița creată cu succes'
        }
    } catch (error) {
        console.error('Eroare creare poliță:', error)
        throw new Error(error.response?.data?.message || 'Eroare la crearea poliței')
    }
}

const downloadPolicyPDF = async (policyId, insurerName, event) => {
    try {
        if (event?.preventDefault) event.preventDefault();
        if (!policyId) throw new Error('Lipsește ID-ul poliței.');

        const token = localStorage.getItem('rca_token');
        if (!token) throw new Error('Token lipsă.');

        const response = await fetch(`https://rca-qa.api.lifeishard.ro/policy/${policyId}`, {
            method: 'GET',
            headers: {
                Accept: 'application/json',
                Token: token,
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            const errData = await response.json().catch(() => ({}));
            throw new Error(`Eroare ${response.status}: ${errData.message || 'Nedefinită'}`);
        }

        const json = await response.json();

        // Verificăm structura răspunsului pentru PDF
        const pdfContent = json.data?.files?.[0]?.content || json.data?.content;
        if (!pdfContent) throw new Error('Conținutul PDF nu a fost găsit în răspuns.');

        // Decodare Base64 la fel ca în downloadOfferPDF
        const byteCharacters = atob(pdfContent);
        const byteNumbers = new Array(byteCharacters.length);
        for (let i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
        }
        const blob = new Blob([new Uint8Array(byteNumbers)], { type: 'application/pdf' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        const safeName = `polita_${insurerName}_${policyId}`.replace(/\s+/g, '_');
        a.download = `${safeName}.pdf`;
        document.body.appendChild(a);
        a.click();
        setTimeout(() => {
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }, 150);

    } catch (e) {
        console.error('Eroare descărcare PDF poliță:', e);
        alert('Eroare la descărcarea poliței: ' + e.message);
    }
};

</script>

<style scoped>
.form-container {
    max-width: 1000px;
    margin: 20px auto;
    padding: 25px;
    background: #f0f8ff;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}
.auth-section {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #ddd;
}
.login-btn {
    background: #27ae60;
    color: white;
    border: none;
    padding: 0.7rem 1.2rem;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s;
}
.login-btn:hover {
    background: #2ecc71;
}
.token-indicator {
    margin-left: 1rem;
    font-weight: bold;
    font-size: 0.9rem;
}
.insurance-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}
.form-section {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}
.form-section h3 {
    margin-top: 0;
    margin-bottom: 1.2rem;
    color: #2c3e50;
    border-bottom: 1px solid #eee;
    padding-bottom: 0.5rem;
}
.form-section h4 {
    margin: 1.2rem 0 0.8rem;
    color: #34495e;
}
.form-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}
.form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
    margin-bottom: 0.5rem;
}
.form-group label {
    margin-bottom: 0.3rem;
    font-weight: 500;
    font-size: 0.9rem;
    color: #4a5568;
}
.form-input, select {
    padding: 0.6rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.9rem;
    transition: border 0.3s;
}
.form-input:focus, select:focus {
    border-color: #3498db;
    outline: none;
}
input[type="checkbox"] {
    width: auto;
    margin-top: 0.5rem;
}
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
}
.submit-btn {
    background: #3498db;
    color: white;
    padding: 0.8rem 1.5rem;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
}
.submit-btn:hover {
    background: #2980b9;
}
.reset-btn {
    background: #e74c3c;
    color: white;
    padding: 0.8rem 1.5rem;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
}
.reset-btn:hover {
    background: #c0392b;
}
.offers-wrapper {
    margin-top: 2rem;
}
.offers-grid {
    display: grid;
    gap: 1rem;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
}
.offer-card {
    background: white;
    border-radius: 12px;
    padding: 1rem 1.2rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    border: 2px solid transparent;
    transition: transform .2s, box-shadow .2s;
}
.offer-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
}
.offer-card.success {
    border-color: #27ae60;
}
.offer-card.error {
    border-color: #e74c3c;
}
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}
.insurer-name {
    font-weight: 700;
    font-size: 1.05rem;
    text-transform: capitalize;
}
.status-badge {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-flex;
    align-items: center;
}
.status-badge[data-status="success"] {
    background: #e6f7ef;
    color: #1f8f4f;
}
.status-badge[data-status="error"] {
    background: #fde6e6;
    color: #c0392b;
}
.card-body .field {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.35rem;
    flex-wrap: wrap;
}
.label {
    font-size: 0.75rem;
    color: #6b7280;
    font-weight: 600;
    flex: 1 1 40%;
}
.value {
    font-weight: 600;
    flex: 1 1 55%;
    text-align: right;
    word-break: break-word;
}
.error-text {
    color: #c0392b;
}
.pid-link {
    text-decoration: none;
    font-size: 0.85rem;
    background: #3498db;
    color: white;
    padding: 5px 10px;
    border-radius: 6px;
    display: inline-block;
    transition: background .2s;
}
.pid-link:hover {
    background: #256fa8;
}

</style>
