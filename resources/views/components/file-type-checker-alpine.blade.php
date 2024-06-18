<template x-if="file.file_type === 'application/pdf'">
    <a :href="path" target="_blank" class="text-md flex rounded-md bg-gray-700 p-2 hover:bg-gray-700/75">
        <svg class="mr-2 h-6 w-6" fill="rgb(185 28 28)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <title>PDF</title>
            <path
                d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M9.5 11.5C9.5 12.3 8.8 13 8 13H7V15H5.5V9H8C8.8 9 9.5 9.7 9.5 10.5V11.5M14.5 13.5C14.5 14.3 13.8 15 13 15H10.5V9H13C13.8 9 14.5 9.7 14.5 10.5V13.5M18.5 10.5H17V11.5H18.5V13H17V15H15.5V9H18.5V10.5M12 10.5H13V13.5H12V10.5M7 10.5H8V11.5H7V10.5Z" />
        </svg>
        <span class="truncate" x-text="file.filename.replace('uploads/', '').split('_').slice(2).join('_')"></span>
    </a>
</template>

<template x-if="file.file_type.endsWith('document')">
    <a :href="path" target="_blank" download
        class="text-md flex rounded-md bg-gray-700 p-2 hover:bg-gray-700/75">
        <svg class="mr-2 h-6 w-6" fill="rgb(2 132 199)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <title>WORD</title>
            <path
                d="M15.5,17H14L12,9.5L10,17H8.5L6.1,7H7.8L9.34,14.5L11.3,7H12.7L14.67,14.5L16.2,7H17.9M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
        </svg>
        <span class="truncate" x-text="file.filename.replace('uploads/', '').split('_').slice(2).join('_')"></span>
    </a>
</template>

<template x-if="['xlsx', 'xls', 'csv'].some(ext => file.filename.endsWith(ext))">
    <a :href="path" target="_blank" download
        class="text-md flex rounded-md bg-gray-700 p-2 hover:bg-gray-700/75">
        <svg class="mr-2 h-6 w-6" fill="rgb(22 163 74)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <title>EXCEL</title>
            <path
                d="M16.2,17H14.2L12,13.2L9.8,17H7.8L11,12L7.8,7H9.8L12,10.8L14.2,7H16.2L13,12M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
        </svg>
        <span class="truncate" x-text="file.filename.replace('uploads/', '').split('_').slice(2).join('_')"></span>
    </a>
</template>

<template x-if="['txt'].some(ext => file.filename.endsWith(ext))">
    <a :href="path" target="_blank" download
        class="text-md flex rounded-md bg-gray-700 p-2 hover:bg-gray-700/75">
        <svg class="mr-2 h-6 w-6" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <title>TXT</title>
            <path
                d="M14,17H7V15H14M17,13H7V11H17M17,9H7V7H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
        </svg>
        <span class="truncate" x-text="file.filename.replace('uploads/', '').split('_').slice(2).join('_')"></span>
    </a>
</template>

<template x-if=" ['jpeg', 'jpg', 'png', 'jfif'].some(ext => file.filename.endsWith(ext)) && imageShow == true">
    <a :href="path" target="_blank">
        <img class="" :src="path" :class="{ 'landscape': $el.naturalWidth > $el.naturalHeight }">
    </a>
</template>

<template x-if=" ['jpeg', 'jpg', 'png', 'jfif'].some(ext => file.filename.endsWith(ext)) && imageShow == false">
    <a :href="path" target="_blank" download
        class="text-md flex rounded-md bg-gray-700 p-2 hover:bg-gray-700/75">
        <svg class="mr-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path fill="currentColor"
                d="M8.5,13.5L11,16.5L14.5,12L19,18H5M21,19V5C21,3.89 20.1,3 19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19Z" />
        </svg>
        <span class="truncate" x-text="file.filename.replace('uploads/', '').split('_').slice(2).join('_')"></span>
    </a>
</template>

{{-- <template
    x-if="!['pdf', 'document', 'xlsx', 'xls', 'csv', 'txt'].some(ext => file.file_type.includes(ext) || file.filename.endsWith(ext))">
    
        <a :href="path" target="_blank" download
            class="text-md flex rounded-md bg-gray-700 p-2 hover:bg-gray-700/75">
            <svg class="mr-2 h-6 w-6" fill="gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <title>FILE</title>
                <path
                    d="M13,9H18.5L13,3.5V9M6,2H14L20,8V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V4C4,2.89 4.89,2 6,2M15,18V16H6V18H15M18,14V12H6V14H18Z" />
            </svg>
            <span class="truncate" x-text="file.filename.replace('uploads/', '').split('_').slice(2).join('_')"></span>
        </a>
</template> --}}
