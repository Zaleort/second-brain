package com.zaleort.second_brain.Shared.Infrastructure.JwtManager

import com.zaleort.second_brain.Shared.Domain.JwtManager.JwtManagerInterface
import jakarta.servlet.FilterChain
import jakarta.servlet.http.HttpServletRequest
import jakarta.servlet.http.HttpServletResponse
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken
import org.springframework.security.core.context.SecurityContextHolder
import org.springframework.stereotype.Component
import org.springframework.web.filter.OncePerRequestFilter

@Component
class JwtAuthorizationFilter(
    private val jwtManager: JwtManagerInterface,
    private val userDetailsService: JwtUserDetailsService,
) : OncePerRequestFilter() {
    override fun doFilterInternal(request: HttpServletRequest, response: HttpServletResponse, filterChain: FilterChain) {
        val token = request.getHeader("Authorization")?.substring(7)
        if (token != null) {
            val payload = jwtManager.decode(token)
            val userDetails = userDetailsService.loadUserByUsername(payload.id)
            val authentication = UsernamePasswordAuthenticationToken(userDetails, null, userDetails.authorities)
            SecurityContextHolder.getContext().authentication = authentication
        }

        filterChain.doFilter(request, response)
    }
}