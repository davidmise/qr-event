<template>
  <div>
    <UploadComponent />
    <TemplateListComponent @template-selected="loadTemplate"></TemplateListComponent>
    <div v-if="selectedTemplate">
      <h2>{{ selectedTemplate.name }}</h2>
      <div v-html="renderedTemplate"></div>
    </div>
    <QRCodeComponent></QRCodeComponent>
  </div>
</template>

<script>
import TemplateListComponent from '@/components/Cardtemplates/ListTemplate.vue'
import QRCodeComponent from '@/components/Cardtemplates/TemplateUpload.vue'
import UploadComponent from '@/components/Cardtemplates/OverlayUpload.vue'

export default {
  components: {
    TemplateListComponent,
    QRCodeComponent,
    UploadComponent
  },
  data() {
    return {
      selectedTemplate: null,
      guestData: {
        name: 'John Doe',
        qrCode: 'https://example.com/qrcode'
      },
      renderedTemplate: ''
    }
  },
  methods: {
    async loadTemplate(template) {
      this.selectedTemplate = template
      const response = await this.$axios.get(`http://127.0.0.1:8000/api/templates/${template.id}`)
      const templateHtml = await fetch(response.data.path).then((res) => res.text())
      this.renderedTemplate = this.processTemplate(templateHtml)
    },
    processTemplate(templateHtml) {
      return templateHtml
        .replace('{{name}}', this.guestData.name)
        .replace('{{qrcode}}', `<canvas id="qrcode"></canvas>`)
    }
  },
  watch: {
    guestData: {
      handler() {
        if (this.selectedTemplate) {
          this.renderedTemplate = this.processTemplate(this.renderedTemplate)
        }
      },
      deep: true
    }
  }
}
</script>
