import PageList from './components/BoxList'
import PageView from './components/BoxView'

export const routes = [
    {
        path: '/boxes',
        name: 'Boxes',
        component: BoxList,
    },
    {
        path: '/boxes/:id',
        name: 'Show Box',
        component: BoxView,
        hidden: true
    },
]
