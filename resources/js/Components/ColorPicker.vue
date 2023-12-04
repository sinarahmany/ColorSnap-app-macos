<template>
    <div class="p-3 pb-1 bg-transparent">
        <div class="flex flex-col justify-between">
            <div class="rounded-full relative">
                <input class="w-full h-12 rounded" placeholder="sss" type="color" v-model="form.selectedColor" @input="updateColorFromMain"/>
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round"
        d="M4.098 19.902a3.75 3.75 0 005.304 0l6.401-6.402M6.75 21A3.75 3.75 0 013 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 003.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008z"/>
</svg>

                </span>
            </div>
            <div class="column is-one-third">
                <div class="color-info">
                    <div class="divide-y divide-gray-200 text-sm">

                        <!--                            <label class="label">HEX:</label>-->
                        <!--                            <div class="control">-->
                        <!--                                <input class="input" v-model="hex" @input="updateColorFromHex" readonly/>-->
                        <!--                            </div>-->
                        <InputColorSection label="HEX" v-model="hex" @input="updateColorFromHex"/>
                        <InputColorSection label="RGB" v-model="rgb" @input="updateColorFromRGB"/>
                        <InputColorSection label="CMYK" v-model="cmyk" @input="updateColorFromCMYK"/>
                        <InputColorSection label="HSB" v-model="hsb" @input="updateColorFromHSB"/>
                        <InputColorSection label="HUE" v-model="hue" @input="updateColorFromHSL"/>
                        <InputColorSection label="HSL" v-model="hsl" @input="updateColorFromHSL"/>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <hr class="mt-4 border-gray-200"/>
            <span class="block text-sm text-gray-500 text-center">Developed by Sina.</span>
        </div>
    </div>

</template>

<script>
import InputColorSection from "@/Components/ColorPicker/InputColorSection.vue";
import {router} from '@inertiajs/vue3';
import debounce from 'lodash.debounce'


export default {
    components: {InputColorSection},
    props: ['data'],
    data() {
        return {
            form: {
                selectedColor: '#000000',
            },
            rgb: this.calculateRGB('#fcba03'),
            cmyk: this.calculateCMYK('#fcba03'),
            hex: '#fcba03',
            hsb: this.calculateHSB('#fcba03'),
            hue: this.calculateHue('#fcba03'),
            hsl: this.calculateHSL('#fcba03'),
        };
    },
    watch: {
        'form.selectedColor': debounce(function(newForm, oldForm) {
            if (newForm && oldForm) {
                this.submit();
            }
        }, 400),
    },
    created() {
        this.form.selectedColor = this.data
        this.rgb = this.calculateRGB(this.data)
        this.cmyk = this.calculateCMYK(this.data)
        this.hex = this.data
        this.hsb = this.calculateHSB(this.data)
        this.hue = this.calculateHue(this.data)
        this.hsl = this.calculateHSL(this.data)
    },
    methods: {
        submit() {
            router.post('/color-picker', this.form)
        },
        cmykToHex(cmyk) {
            const [c, m, y, k] = cmyk.split(",").map(Number);
            const r = 255 * (1 - Math.min(1, c * (1 - k) + k));
            const g = 255 * (1 - Math.min(1, m * (1 - k) + k));
            const b = 255 * (1 - Math.min(1, y * (1 - k) + k));
            const hex = `#${Math.round(r).toString(16).padStart(2, "0")}${Math.round(g).toString(16).padStart(2, "0")}${Math.round(b).toString(16).padStart(2, "0")}`;
            return hex.toUpperCase();
        },
        updateColorFromMain() {

            this.hex = this.form.selectedColor;
            this.rgb = this.calculateRGB(this.form.selectedColor);
            this.cmyk = this.calculateCMYK(this.form.selectedColor);
            this.hsb = this.calculateHSB(this.form.selectedColor);
            this.hue = this.calculateHue(this.form.selectedColor);
            this.hsl = this.calculateHSL(this.form.selectedColor);
        },
        updateColorFromHex() {
            this.form.selectedColor = this.hex;
            this.rgb = this.calculateRGB(this.form.selectedColor);
            this.cmyk = this.calculateCMYK(this.form.selectedColor);
            this.hsb = this.calculateHSB(this.form.selectedColor);
            this.hue = this.calculateHue(this.form.selectedColor);
            this.hsl = this.calculateHSL(this.form.selectedColor);
        },
        updateColorFromRGB() {
            this.form.selectedColor = this.rgbToHex(this.rgb);
            this.hex = this.form.selectedColor;
            this.cmyk = this.calculateCMYK(this.form.selectedColor);
            this.hsb = this.calculateHSB(this.form.selectedColor);
            this.hue = this.calculateHue(this.form.selectedColor);
            this.hsl = this.calculateHSL(this.form.selectedColor);
        },
        updateColorFromCMYK() {
            this.form.selectedColor = this.cmykToHex(this.cmyk);
            this.hex = this.form.selectedColor;
            this.rgb = this.calculateRGB(this.form.selectedColor);
            this.hsb = this.calculateHSB(this.form.selectedColor);
            this.hue = this.calculateHue(this.form.selectedColor);
            this.hsl = this.calculateHSL(this.form.selectedColor);
        },
        updateColorFromHSB() {
            this.form.selectedColor = this.hsbToHex(this.hsb);
            this.hex = this.form.selectedColor;
            this.rgb = this.calculateRGB(this.form.selectedColor);
            this.cmyk = this.calculateCMYK(this.form.selectedColor);
            this.hue = this.calculateHue(this.form.selectedColor);
            this.hsl = this.calculateHSL(this.form.selectedColor);
        },
        updateColorFromHSL() {
            this.form.selectedColor = this.hslToHex(this.hsl);
            this.hex = this.form.selectedColor;
            this.rgb = this.calculateRGB(this.form.selectedColor);
            this.cmyk = this.calculateCMYK(this.form.selectedColor);
            this.hsb = this.calculateHSB(this.form.selectedColor);
            this.hue = this.calculateHue(this.form.selectedColor);
        },
        calculateRGB(hex) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `${r},${g},${b}`;
        },
        calculateCMYK(hex) {
            const [r, g, b] = this.calculateRGB(hex).split(',').map(Number);
            const c = 1 - r / 255;
            const m = 1 - g / 255;
            const y = 1 - b / 255;
            const k = Math.min(c, m, y);
            return `${Math.round(c * 100)},${Math.round(m * 100)},${Math.round(y * 100)},${Math.round(k * 100)}`;
        },
        rgbToHex(rgb) {
            const [r, g, b] = rgb.split(',').map(Number);
            const hex = `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
            return hex.toUpperCase();
        },
        calculateHSB(hex) {
            const [r, g, b] = this.calculateRGB(hex).split(',').map(Number);
            const max = Math.max(r, g, b);
            const min = Math.min(r, g, b);
            const delta = max - min;
            let h = 0;
            if (delta !== 0) {
                if (max === r) {
                    h = (60 * ((g - b) / delta) + 360) % 360;
                } else if (max === g) {
                    h = (60 * ((b - r) / delta) + 120);
                } else {
                    h = (60 * ((r - g) / delta) + 240);
                }
            }
            const s = max === 0 ? 0 : (delta / max) * 100;
            const v = (max / 255) * 100;
            return `${Math.round(h)},${Math.round(s)},${Math.round(v)}`;
        },
        hsbToHex(hsb) {
            const [h, s, v] = hsb.split(',').map(Number);
            const c = (s / 100) * (v / 100);
            const x = c * (1 - Math.abs(((h / 60) % 2) - 1));
            const m = (v / 100) - c;
            let r, g, b;
            if (h >= 0 && h < 60) {
                r = c;
                g = x;
                b = 0;
            } else if (h >= 60 && h < 120) {
                r = x;
                g = c;
                b = 0;
            } else if (h >= 120 && h < 180) {
                r = 0;
                g = c;
                b = x;
            } else if (h >= 180 && h < 240) {
                r = 0;
                g = x;
                b = c;
            } else if (h >= 240 && h < 300) {
                r = x;
                g = 0;
                b = c;
            } else {
                r = c;
                g = 0;
                b = x;
            }
            r = Math.round((r + m) * 255);
            g = Math.round((g + m) * 255);
            b = Math.round((b + m) * 255);
            const hex = `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
            return hex.toUpperCase();
        },
        calculateHue(hex) {
            const [r, g, b] = this.calculateRGB(hex).split(',').map(Number);
            const max = Math.max(r, g, b);
            const min = Math.min(r, g, b);
            const delta = max - min;
            let hue = 0;
            if (delta !== 0) {
                if (max === r) {
                    hue = (60 * ((g - b) / delta) + 360) % 360;
                } else if (max === g) {
                    hue = (60 * ((b - r) / delta) + 120);
                } else {
                    hue = (60 * ((r - g) / delta) + 240);
                }
            }
            return Math.round(hue);
        },
        calculateHSL(hex) {
            const [r, g, b] = this.calculateRGB(hex).split(',').map(Number);
            const max = Math.max(r, g, b);
            const min = Math.min(r, g, b);
            const delta = max - min;
            const lightness = (max + min) / 2;
            let saturation = 0;
            if (delta !== 0) {
                saturation = (delta / (1 - Math.abs(2 * lightness - 1))) * 100;
            }
            return `${this.calculateHue(hex)},${Math.round(saturation)},${Math.round(lightness)}`;
        },
        hslToHex(hsl) {
            const [h, s, l] = hsl.split(',').map(Number);
            const c = (1 - Math.abs(2 * (l / 100) - 1)) * (s / 100);
            const x = c * (1 - Math.abs(((h / 60) % 2) - 1));
            const m = (l / 100) - c / 2;
            let r, g, b;
            if (h >= 0 && h < 60) {
                r = c;
                g = x;
                b = 0;
            } else if (h >= 60 && h < 120) {
                r = x;
                g = c;
                b = 0;
            } else if (h >= 120 && h < 180) {
                r = 0;
                g = c;
                b = x;
            } else if (h >= 180 && h < 240) {
                r = 0;
                g = x;
                b = c;
            } else if (h >= 240 && h < 300) {
                r = x;
                g = 0;
                b = c;
            } else {
                r = c;
                g = 0;
                b = x;
            }
            r = Math.round((r + m) * 255);
            g = Math.round((g + m) * 255);
            b = Math.round((b + m) * 255);
            const hex = `#${r.toString(16).padStart(2, '0')}${g.toString(16).padStart(2, '0')}${b.toString(16).padStart(2, '0')}`;
            return hex.toUpperCase();
        },
    },
};
</script>

<style scoped>
.color-info {
    text-align: center;
}

.field {
    margin-bottom: 1rem;
}

[type="color"] {
    appearance: none;
    border: 0;
    padding: 0;
    cursor: pointer;
    background-color: transparent;
}

[type="color"]::-webkit-color-swatch {
    border-radius: 0.5rem;
    border-color: #e5e7eb;
}

[type="color"]::-moz-color-swatch {
    border-radius: 0.5rem;
    border-color: #e5e7eb;
}
</style>
