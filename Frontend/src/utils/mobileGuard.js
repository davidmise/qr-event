import { isMobile } from './isMobile'

export function mobileGuard(to, from, next) {
  if (isMobile()) {
    next()
  } else {
    next('/')
  }
}
