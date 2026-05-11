/**
 * Three.js 3D Scene — Hero Background
 * Premium realistic construction visualization
 */

class BuilderScene {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        if (!this.container) return;

        this.scene = new THREE.Scene();
        this.clock = new THREE.Clock();
        this.mouse = { x: 0, y: 0 };
        this.buildings = [];
        this.craneGroup = null;
        this.floatingShapes = [];

        this.init();
        this.createEnvironment();
        this.createCityscape();
        this.createHeroBuildingConstruction();
        this.createCrane();
        this.createFloatingParticles();
        this.createFloatingGeometry();
        this.addEventListeners();
        this.animate();
    }

    init() {
        this.camera = new THREE.PerspectiveCamera(55, this.container.clientWidth / this.container.clientHeight, 0.1, 500);
        this.camera.position.set(18, 10, 22);
        this.camera.lookAt(5, 5, 0);

        this.renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        this.renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        this.renderer.shadowMap.enabled = true;
        this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        this.renderer.toneMapping = THREE.ACESFilmicToneMapping;
        this.renderer.toneMappingExposure = 1.2;
        this.container.appendChild(this.renderer.domElement);

        this.scene.fog = new THREE.FogExp2(0x020617, 0.012);
    }

    createEnvironment() {
        // Ambient
        const ambient = new THREE.AmbientLight(0x1a1a3e, 0.5);
        this.scene.add(ambient);

        // Key light — warm golden sun
        const sun = new THREE.DirectionalLight(0xffb347, 1.2);
        sun.position.set(15, 25, 10);
        sun.castShadow = true;
        sun.shadow.mapSize.set(2048, 2048);
        sun.shadow.camera.near = 0.5;
        sun.shadow.camera.far = 80;
        sun.shadow.camera.left = -30;
        sun.shadow.camera.right = 30;
        sun.shadow.camera.top = 30;
        sun.shadow.camera.bottom = -10;
        this.scene.add(sun);

        // Fill — cool blue
        const fill = new THREE.DirectionalLight(0x4488ff, 0.4);
        fill.position.set(-15, 12, -8);
        this.scene.add(fill);

        // Rim light — amber glow
        const rim = new THREE.DirectionalLight(0xf59e0b, 0.6);
        rim.position.set(-5, 8, 20);
        this.scene.add(rim);

        // Orbiting spot
        this.orbitLight = new THREE.PointLight(0xf59e0b, 1.5, 40);
        this.orbitLight.position.set(0, 15, 5);
        this.scene.add(this.orbitLight);

        // Ground
        const groundGeo = new THREE.PlaneGeometry(120, 80);
        const groundMat = new THREE.MeshPhongMaterial({ color: 0x080e1d, transparent: true, opacity: 0.9 });
        const ground = new THREE.Mesh(groundGeo, groundMat);
        ground.rotation.x = -Math.PI / 2;
        ground.position.y = -0.05;
        ground.receiveShadow = true;
        this.scene.add(ground);

        // Grid
        const grid = new THREE.GridHelper(120, 80, 0x1e293b, 0x0d1525);
        grid.material.opacity = 0.25;
        grid.material.transparent = true;
        this.scene.add(grid);
    }

    // --- Materials ---
    mat(color, emissive, spec, shin, opacity) {
        return new THREE.MeshPhongMaterial({
            color, emissive: emissive || 0x000000, specular: spec || 0x111111,
            shininess: shin || 30, transparent: opacity < 1, opacity: opacity || 1
        });
    }

    glassMat() {
        return new THREE.MeshPhongMaterial({
            color: 0x88bbff, emissive: 0x112244, specular: 0xffffff,
            shininess: 120, transparent: true, opacity: 0.35,
            reflectivity: 1, envMap: null
        });
    }

    // --- Realistic multi-floor building ---
    makeBuilding(x, z, w, d, floors, style) {
        const g = new THREE.Group();
        const floorH = 1.4;
        const h = floors * floorH;

        // Concrete body
        const bodyColor = style === 'glass' ? 0x1a2a40 : style === 'modern' ? 0x2a3040 : 0x1e293b;
        const body = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), this.mat(bodyColor, 0x0a0f1a, 0x334155, 40, 0.92));
        body.position.y = h / 2;
        body.castShadow = true;
        body.receiveShadow = true;
        g.add(body);

        // Floor separators
        for (let i = 1; i <= floors; i++) {
            const sep = new THREE.Mesh(
                new THREE.BoxGeometry(w + 0.15, 0.06, d + 0.15),
                this.mat(0x334155, 0x1e293b, 0x475569, 20, 0.7)
            );
            sep.position.y = i * floorH;
            g.add(sep);
        }

        // Windows — glowing panes
        const winMat = this.glassMat();
        const litWinMat = new THREE.MeshPhongMaterial({
            color: 0xfbbf24, emissive: 0xf59e0b, emissiveIntensity: 0.8,
            transparent: true, opacity: 0.7
        });

        for (let f = 0; f < floors; f++) {
            const cols = Math.max(2, Math.floor(w / 0.8));
            const spacing = w / (cols + 1);
            for (let c = 1; c <= cols; c++) {
                const lit = Math.random() > 0.4;
                const wm = new THREE.Mesh(
                    new THREE.PlaneGeometry(spacing * 0.6, floorH * 0.55),
                    lit ? litWinMat.clone() : winMat.clone()
                );
                wm.position.set(-w / 2 + c * spacing, f * floorH + floorH * 0.6, d / 2 + 0.02);
                g.add(wm);

                // Back face
                const wmb = wm.clone();
                wmb.position.z = -d / 2 - 0.02;
                wmb.rotation.y = Math.PI;
                g.add(wmb);
            }
        }

        // Rooftop detail
        const roofBase = new THREE.Mesh(
            new THREE.BoxGeometry(w * 0.9, 0.2, d * 0.9),
            this.mat(0x1e293b, 0x0f172a, 0x334155, 20, 0.9)
        );
        roofBase.position.y = h + 0.1;
        g.add(roofBase);

        // Antenna / helipad
        if (floors > 8) {
            const ant = new THREE.Mesh(
                new THREE.CylinderGeometry(0.04, 0.04, 2, 8),
                this.mat(0x64748b, 0x334155, 0x94a3b8, 60, 1)
            );
            ant.position.y = h + 1.2;
            g.add(ant);
            // Blinking light
            const blink = new THREE.Mesh(
                new THREE.SphereGeometry(0.1, 8, 8),
                new THREE.MeshPhongMaterial({ color: 0xff3333, emissive: 0xff0000, emissiveIntensity: 1 })
            );
            blink.position.y = h + 2.3;
            blink.userData.blink = true;
            g.add(blink);
        }

        g.position.set(x, 0, z);
        g.userData = { baseY: 0, speed: 0.2 + Math.random() * 0.3, offset: Math.random() * 6.28, floors };
        return g;
    }

    createCityscape() {
        const configs = [
            // x, z, w, d, floors, style
            [-14, -10, 3, 3, 12, 'glass'],
            [-10, -12, 2.5, 2.5, 8, 'modern'],
            [-7, -8, 2, 2, 6, 'concrete'],
            [-4, -14, 3, 2.5, 10, 'glass'],
            [5, -10, 2.5, 2.5, 7, 'modern'],
            [8, -12, 2, 2, 9, 'glass'],
            [12, -8, 3, 3, 11, 'concrete'],
            [15, -11, 2, 2, 5, 'modern'],
            [-12, -16, 2, 2, 6, 'concrete'],
            [10, -16, 2.5, 2.5, 8, 'glass'],
            [-2, -18, 2, 3, 4, 'modern'],
            [3, -15, 2, 2, 6, 'concrete'],
        ];
        configs.forEach(c => {
            const b = this.makeBuilding(c[0], c[1], c[2], c[3], c[4], c[5]);
            this.buildings.push(b);
            this.scene.add(b);
        });
    }

    // --- Hero building under construction ---
    createHeroBuildingConstruction() {
        const g = new THREE.Group();
        const w = 5, d = 4, totalFloors = 16, builtFloors = 11;
        const floorH = 1.4;
        const builtH = builtFloors * floorH;

        // Built portion — solid
        const builtBody = new THREE.Mesh(
            new THREE.BoxGeometry(w, builtH, d),
            this.mat(0x1e293b, 0x0f172a, 0x475569, 50, 0.95)
        );
        builtBody.position.y = builtH / 2;
        builtBody.castShadow = true;
        builtBody.receiveShadow = true;
        g.add(builtBody);

        // Floor slabs
        for (let i = 0; i <= builtFloors; i++) {
            const slab = new THREE.Mesh(
                new THREE.BoxGeometry(w + 0.2, 0.12, d + 0.2),
                this.mat(0x475569, 0x1e293b, 0x64748b, 30, 0.85)
            );
            slab.position.y = i * floorH;
            g.add(slab);
        }

        // Lit windows
        const litMat = new THREE.MeshPhongMaterial({
            color: 0xfbbf24, emissive: 0xf59e0b, emissiveIntensity: 0.9,
            transparent: true, opacity: 0.75
        });
        const glassMat = this.glassMat();

        for (let f = 0; f < builtFloors; f++) {
            for (let c = 0; c < 4; c++) {
                const lit = Math.random() > 0.35;
                const wn = new THREE.Mesh(
                    new THREE.PlaneGeometry(0.8, floorH * 0.5),
                    lit ? litMat.clone() : glassMat.clone()
                );
                wn.position.set(-w / 2 + 0.8 + c * 1.1, f * floorH + floorH * 0.6, d / 2 + 0.02);
                g.add(wn);
            }
        }

        // Under-construction skeleton (rebar/framework)
        const frameMat = this.mat(0x94a3b8, 0x334155, 0xcbd5e1, 80, 0.6);
        for (let f = builtFloors; f < totalFloors; f++) {
            // Columns
            for (let cx = -1; cx <= 1; cx += 2) {
                for (let cz = -1; cz <= 1; cz += 2) {
                    const col = new THREE.Mesh(
                        new THREE.BoxGeometry(0.15, floorH, 0.15),
                        frameMat
                    );
                    col.position.set(cx * (w / 2 - 0.3), f * floorH + floorH / 2, cz * (d / 2 - 0.3));
                    g.add(col);
                }
            }
            // Horizontal beams
            const beam = new THREE.Mesh(
                new THREE.BoxGeometry(w - 0.2, 0.08, 0.08),
                frameMat
            );
            beam.position.y = (f + 1) * floorH;
            beam.position.z = d / 2 - 0.3;
            g.add(beam);
            const beam2 = beam.clone();
            beam2.position.z = -d / 2 + 0.3;
            g.add(beam2);
        }

        // Safety scaffolding (orange mesh)
        const scaffMat = new THREE.MeshPhongMaterial({
            color: 0xff6600, emissive: 0xcc4400, transparent: true, opacity: 0.2, wireframe: true
        });
        const scaff = new THREE.Mesh(
            new THREE.BoxGeometry(w + 0.8, (totalFloors - builtFloors) * floorH, d + 0.8),
            scaffMat
        );
        scaff.position.y = builtH + ((totalFloors - builtFloors) * floorH) / 2;
        g.add(scaff);

        // Golden accent stripe at construction line
        const accentStripe = new THREE.Mesh(
            new THREE.BoxGeometry(w + 0.3, 0.15, d + 0.3),
            new THREE.MeshPhongMaterial({ color: 0xf59e0b, emissive: 0xd97706, emissiveIntensity: 0.8 })
        );
        accentStripe.position.y = builtH;
        g.add(accentStripe);

        g.position.set(0, 0, -4);
        this.heroBuilding = g;
        this.scene.add(g);
    }

    // --- Construction crane ---
    createCrane() {
        const g = new THREE.Group();
        const craneMat = this.mat(0xf59e0b, 0xb45309, 0xfbbf24, 60, 1);
        const darkMat = this.mat(0x334155, 0x1e293b, 0x475569, 40, 1);

        // Vertical mast
        const mast = new THREE.Mesh(new THREE.BoxGeometry(0.4, 28, 0.4), craneMat);
        mast.position.y = 14;
        mast.castShadow = true;
        g.add(mast);

        // Lattice detail on mast
        for (let i = 0; i < 14; i++) {
            const cross = new THREE.Mesh(new THREE.BoxGeometry(0.6, 0.06, 0.06), darkMat);
            cross.position.y = 1 + i * 2;
            g.add(cross);
        }

        // Horizontal jib
        const jib = new THREE.Mesh(new THREE.BoxGeometry(20, 0.3, 0.3), craneMat);
        jib.position.set(4, 27.5, 0);
        jib.castShadow = true;
        g.add(jib);

        // Counter-jib (shorter, back)
        const counterJib = new THREE.Mesh(new THREE.BoxGeometry(7, 0.3, 0.3), craneMat);
        counterJib.position.set(-6, 27.5, 0);
        g.add(counterJib);

        // Counterweight
        const cw = new THREE.Mesh(new THREE.BoxGeometry(1.5, 1, 1), darkMat);
        cw.position.set(-9, 27, 0);
        g.add(cw);

        // Support cables (top triangle)
        const cableMat = this.mat(0x94a3b8, 0x475569, 0xcbd5e1, 80, 0.8);
        const cableGeo = new THREE.CylinderGeometry(0.02, 0.02, 12, 4);
        const cable1 = new THREE.Mesh(cableGeo, cableMat);
        cable1.position.set(4, 30, 0);
        cable1.rotation.z = -0.6;
        g.add(cable1);
        const cable2 = new THREE.Mesh(cableGeo.clone(), cableMat);
        cable2.position.set(-3, 30, 0);
        cable2.rotation.z = 0.5;
        g.add(cable2);

        // Trolley
        const trolley = new THREE.Mesh(new THREE.BoxGeometry(0.6, 0.3, 0.4), darkMat);
        trolley.position.set(8, 27.2, 0);
        g.add(trolley);
        this.craneTrolley = trolley;

        // Hook cable
        const hookCable = new THREE.Mesh(
            new THREE.CylinderGeometry(0.02, 0.02, 8, 4), cableMat
        );
        hookCable.position.set(8, 23, 0);
        g.add(hookCable);
        this.hookCable = hookCable;

        // Hook
        const hook = new THREE.Mesh(
            new THREE.TorusGeometry(0.2, 0.05, 8, 16, Math.PI),
            craneMat
        );
        hook.position.set(8, 19, 0);
        hook.rotation.z = Math.PI;
        g.add(hook);
        this.craneHook = hook;

        // Cabin
        const cabin = new THREE.Mesh(new THREE.BoxGeometry(1.2, 1.2, 1), craneMat);
        cabin.position.set(0.8, 26, 0);
        g.add(cabin);
        // Cabin window
        const cabWin = new THREE.Mesh(
            new THREE.PlaneGeometry(0.8, 0.5),
            this.glassMat()
        );
        cabWin.position.set(0.8, 26.2, 0.51);
        g.add(cabWin);

        // Warning light on top
        const warnLight = new THREE.Mesh(
            new THREE.SphereGeometry(0.12, 8, 8),
            new THREE.MeshPhongMaterial({ color: 0xff3333, emissive: 0xff0000, emissiveIntensity: 1 })
        );
        warnLight.position.set(0, 28.3, 0);
        warnLight.userData.blink = true;
        g.add(warnLight);

        g.position.set(5, 0, -2);
        this.craneGroup = g;
        this.scene.add(g);
    }

    // --- Floating golden particles (dust/sparks) ---
    createFloatingParticles() {
        const count = 350;
        const geo = new THREE.BufferGeometry();
        const pos = new Float32Array(count * 3);
        const sizes = new Float32Array(count);

        for (let i = 0; i < count; i++) {
            pos[i * 3] = (Math.random() - 0.5) * 60;
            pos[i * 3 + 1] = Math.random() * 35;
            pos[i * 3 + 2] = (Math.random() - 0.5) * 40;
            sizes[i] = 0.03 + Math.random() * 0.06;
        }

        geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));

        const mat = new THREE.PointsMaterial({
            color: 0xfbbf24, size: 0.08, transparent: true,
            opacity: 0.5, blending: THREE.AdditiveBlending, sizeAttenuation: true
        });

        this.particles = new THREE.Points(geo, mat);
        this.scene.add(this.particles);
    }

    // --- Floating wireframe shapes ---
    createFloatingGeometry() {
        const mat = new THREE.MeshPhongMaterial({
            color: 0xf59e0b, emissive: 0xb45309, transparent: true, opacity: 0.3, wireframe: true
        });

        for (let i = 0; i < 10; i++) {
            const size = 0.3 + Math.random() * 0.8;
            const geos = [
                new THREE.OctahedronGeometry(size),
                new THREE.IcosahedronGeometry(size),
                new THREE.TetrahedronGeometry(size),
                new THREE.DodecahedronGeometry(size * 0.7)
            ];
            const mesh = new THREE.Mesh(geos[Math.floor(Math.random() * geos.length)], mat.clone());
            mesh.position.set(
                (Math.random() - 0.5) * 40,
                4 + Math.random() * 20,
                (Math.random() - 0.5) * 25
            );
            mesh.userData = {
                rx: (Math.random() - 0.5) * 0.015,
                ry: (Math.random() - 0.5) * 0.015,
                rz: (Math.random() - 0.5) * 0.01,
                floatSpd: 0.3 + Math.random() * 0.6,
                floatOff: Math.random() * 6.28,
                baseY: mesh.position.y
            };
            this.floatingShapes.push(mesh);
            this.scene.add(mesh);
        }
    }

    addEventListeners() {
        window.addEventListener('mousemove', (e) => {
            this.mouse.x = (e.clientX / window.innerWidth) * 2 - 1;
            this.mouse.y = -(e.clientY / window.innerHeight) * 2 + 1;
        });
        window.addEventListener('resize', () => {
            if (!this.container) return;
            this.camera.aspect = this.container.clientWidth / this.container.clientHeight;
            this.camera.updateProjectionMatrix();
            this.renderer.setSize(this.container.clientWidth, this.container.clientHeight);
        });
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        const t = this.clock.getElapsedTime();

        // Smooth camera follow mouse — biased right
        const targetX = 18 + this.mouse.x * 4;
        const targetY = 10 + this.mouse.y * 2;
        this.camera.position.x += (targetX - this.camera.position.x) * 0.015;
        this.camera.position.y += (targetY - this.camera.position.y) * 0.015;
        this.camera.lookAt(5, 5, 0);

        // Buildings subtle float
        this.buildings.forEach(b => {
            b.position.y = b.userData.baseY + Math.sin(t * b.userData.speed + b.userData.offset) * 0.08;
        });

        // Crane slow rotation
        if (this.craneGroup) {
            this.craneGroup.rotation.y = Math.sin(t * 0.15) * 0.25;
        }

        // Trolley slide
        if (this.craneTrolley) {
            const tx = 4 + Math.sin(t * 0.3) * 5;
            this.craneTrolley.position.x = tx;
            if (this.hookCable) this.hookCable.position.x = tx;
            if (this.craneHook) this.craneHook.position.x = tx;
        }

        // Blinking lights
        this.scene.traverse(obj => {
            if (obj.userData && obj.userData.blink) {
                obj.material.emissiveIntensity = Math.sin(t * 4) > 0 ? 1 : 0.1;
                obj.visible = Math.sin(t * 3) > -0.3;
            }
        });

        // Floating shapes
        this.floatingShapes.forEach(s => {
            s.rotation.x += s.userData.rx;
            s.rotation.y += s.userData.ry;
            s.rotation.z += s.userData.rz;
            s.position.y = s.userData.baseY + Math.sin(t * s.userData.floatSpd + s.userData.floatOff) * 1.2;
        });

        // Particles drift
        if (this.particles) {
            this.particles.rotation.y = t * 0.015;
            const pos = this.particles.geometry.attributes.position.array;
            for (let i = 0; i < pos.length; i += 3) {
                pos[i + 1] += 0.005;
                if (pos[i + 1] > 35) pos[i + 1] = 0;
            }
            this.particles.geometry.attributes.position.needsUpdate = true;
        }

        // Orbit light
        if (this.orbitLight) {
            this.orbitLight.position.x = Math.sin(t * 0.4) * 12;
            this.orbitLight.position.z = Math.cos(t * 0.4) * 10;
            this.orbitLight.intensity = 1.2 + Math.sin(t * 0.8) * 0.3;
        }

        this.renderer.render(this.scene, this.camera);
    }

    dispose() {
        if (this.renderer) this.renderer.dispose();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('hero-canvas')) {
        window.builderScene = new BuilderScene('hero-canvas');
    }
});
