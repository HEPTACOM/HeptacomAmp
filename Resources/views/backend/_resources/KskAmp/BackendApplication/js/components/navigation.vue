<template>
    <div>
        <nav class="uk-navbar-container" uk-navbar>
            <div class="uk-navbar-left">
                <ul class="uk-navbar-nav">
                    <li class="uk-navbar-item uk-logo">
                        <a href="https://www.ksk-agentur.de/" target="_blank">
                            <img src="../../custom/plugins/HeptacomAmp/Resources/views/backend/ksk_amp_backend_application/assets/ksk-agentur.svg" width="62" height="26" />
                        </a>
                    </li>
                    <li class="uk-navbar-item uk-logo">
                        <a href="https://ampproject.org/" target="_blank">
                            <img src="../../custom/plugins/HeptacomAmp/Resources/views/backend/ksk_amp_backend_application/assets/heptacom_amp.svg" width="26" height="26" />
                        </a>
                    </li>
                    <slot></slot>
                </ul>
            </div>
        </nav>
    </div>
</template>